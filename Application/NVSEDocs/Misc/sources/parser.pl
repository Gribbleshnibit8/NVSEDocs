#!perl -w

use strict;
use warnings;
use File::Basename;


my $file = $ARGV[0];		# gets the file passed in from command line
if (defined $file) {} else {
	print "Please enter the name of the file: " ;	# if file not passed
	my $file = <STDIN>;								# in ask for it instead
	chop $file;
}

foreach my$file (@ARGV) {
open my $info, $file or die "Could not open $file: $!";
$file =~ s/\.[^.]+$//;
open (MYFILE, "+>", $file.".json") or die "Could not open $file: $!";

my $InDocument;		# holds the data as we read it in
my $OutDocument;	# holds the data as we recompile it

# reads in the file and writes it all to a single variable
while( my $line = <$info>)  {
	$InDocument .= $line;
}

# Remove all <a>,<p>,<b>,&nbsp;,(xxxx) sections
$InDocument =~ s/<\s*a[^>]*><\s*\/\s*a>|(<(p|b)>|<\/(p|b)>)|&nbsp;| \(\d*\)|0x|\"//g;
# Remove all <br> and replace with ,
$InDocument =~ s/\s[\r\n]{0,2}<\s*br.*?>|[\r\n]{0,2}<\s*br.*?>|<\s*br.*?>/,/g;
# Remove all spaces after :
$InDocument =~ s/(?<=\w:)\s//g;
# Remove all lines starting with comma and following a newline
$InDocument =~ s/[\r\n],[\s\w\W]*//g;

#open json
$OutDocument = "{\n";

while($InDocument =~ /([^\n]+)\n?/g) {
	my @data = split(',',$1);
	my $arrPos=0;

# 0 = name
# 1 = alias
# 2 = parameters
# 3 - N = parameters
# N+1 = Return Type N+2= FixMe
# N+3 = Opcode N+4 = Opcode number (use for version)
# N+5 = Condition N+6 = Yes/No
# N+7 = Description N+8 = sentence

#name
	$OutDocument .= "\t\"$data[$arrPos]\": {\n";
	$OutDocument .= "\t\t\"Name\": \"$data[$arrPos]\",\n";
	++$arrPos;

#alias
	my @alias = split(':',$data[$arrPos]);
	$OutDocument .= "\t\t\"Alias\": \"$alias[1]\",\n";
	++$arrPos;

#parameters
	my @params = split(':',$data[$arrPos]);
	$OutDocument .= "\t\t\"NumParameters\": \"$params[1]\",\n";
	$OutDocument .= "\t\t\"Parameters\": [\n";
	for(my $i = 3; $i < $params[1]+3; $i++) {
		my @param = split(/<.*?>/,$data[$i]);
		if ($param[0] eq "") {
			$OutDocument .= "\t\t\t{\"url\": \"\", \"type\": \"$param[1]\", \"optional\": \"true\"},\n";
		} else {
			$OutDocument .= "\t\t\t{\"url\": \"\", \"type\": \"$data[$i]\", \"optional\": \"false\"},\n";
		}
		++$arrPos;
	}
	$OutDocument .= "\t\t],\n";
	++$arrPos;

#returntype
	$OutDocument .= "\t\t\"ReturnType\": [],\n";
	++$arrPos;

#version
	my @vers = split(':',$data[$arrPos]);
	$OutDocument .= "\t\t\"Version\": \"";
	my $opcode = hex($vers[1]);						# Opcode <=
	if($opcode <= 5283) {
		$OutDocument .= "1.1";						# 14A3 == 1.1
	} elsif ($opcode <= 5301) {
		$OutDocument .= "1.2";						# 14B5 == 1.2
	} elsif($opcode le 5307) {
		$OutDocument .= "1.3";						# 14BB == 1.3
	} elsif($opcode le 5319) {
		$OutDocument .= "1.5";						# 14C7 == 1.5
	} elsif($opcode le 5333) {
		$OutDocument .= "1.6";						# 14D5 == 1.6
	} elsif($opcode le 5335) {
		$OutDocument .= "1.9";						# 14D7 == 1.9
	} elsif($opcode le 5345) {
		$OutDocument .= "2.1";						# 14E1 == 2.1
	} elsif($opcode le 5346) {
		$OutDocument .= "2.2";						# 14E2 == 2.2
	} elsif($opcode le 5351) {
		$OutDocument .= "2.5";                      # 14E7 == 2.5
	} elsif($opcode le 5361) {
		$OutDocument .= "2.6";                      # 14F1 == 2.6
	} elsif($opcode le 5366) {
		$OutDocument .= "2.10";                     # 14F6 == 2.10
	} elsif($opcode le 5393) {
		$OutDocument .= "3.1";                      # 1511 == 3.1
	} elsif($opcode le 5531) {
		$OutDocument .= "4.2";                      # 159b == 4.2
	} else {
		$OutDocument .= "Unknown";
	}
	$OutDocument .= "\",\n";
	++$arrPos;

#condition
	my @cond = split(':',$data[$arrPos]);
	$OutDocument .= "\t\t\"Condition\": \"$cond[1]\",\n";
	++$arrPos;

#convention
	$OutDocument .= "\t\t\"Convention\": \"\",\n";

#description
	my @desc = split(':',$data[$arrPos]);
	$desc[1] =~ s/^\s+|\s+$//g;
	$desc[1] = ucfirst($desc[1]);
	chomp $desc[1];
	$OutDocument .= "\t\t\"Description\": [\n";
	$OutDocument .= "\t\t\t\"$desc[1].\"\n\t\t],\n";
	
#description
	$OutDocument .= "\t\t\"Examples\": [],\n";

#tags
	my $tags = "\t\t\"Tags\": [\n\t\t\t";
	if (index($data[0], "Weapon") != -1) {$tags .= "\"Weapon\",";}
	if (index($data[0], "con_") != -1) {$tags .= "\"Console\",";}
	if ((index($data[0], "Logical") != -1) ||
		(index($data[0], "Shift") != -1) ||
		(index($data[0], "Bit") != -1)) {$tags .= "\"Math\",\"Logic\",";}
	if ((index($data[0], "Control") != -1) ||
		(index($data[0], "Key") != -1) ||
		(index($data[0], "Mouse") != -1)) {$tags .= "\"Input\",";}
	if (index($data[0], "sv_") != -1) {$tags .= "\"String\",";}
	if (index($data[0], "ar_") != -1) {$tags .= "\"Array\",";}
	if ((index($data[0], "etUI") != -1) ||
		(index($data[0], "SortUI") != -1)){$tags .= "\"Interface\",";}
	# if (index($data[0], "PN_") != -1) {$tags .= "\"PN\",";}
	$tags .= "\n\t\t]\n";
	$OutDocument .= $tags;

#close function
	$OutDocument .= "\t},\n\n"
}

#close the file
$OutDocument .= "}";

# Remove commas after all last parameters
$OutDocument =~ s/\},\s{3}\]/\}\n\t\t]/g;
# Remove commas after all last tags
$OutDocument =~ s/",\s{3}\]/"\n\t\t\]/g;
# Remove empty lines between []
$OutDocument =~ s/\[\s{0,10}\]/\[\]/g;
# Remove , from end of last function
$OutDocument =~ s/\},\s\s\}/\}\n\}/g;

print MYFILE $OutDocument;

close $info;
close MYFILE;
}