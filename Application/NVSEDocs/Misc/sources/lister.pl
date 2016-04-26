use strict;
use warnings;
use Cwd;

my $dr = getcwd();
chdir($dr."/NVSEFunctions");

open (MYFILE, "+>", "functionsListing.json");

opendir(DIR, $dr."/NVSEFunctions");
my @FILES = readdir(DIR);

print MYFILE "{\n\t\"paths\": [\n";
for(my $i = 2; $i < @FILES; $i++) {
	if ($FILES[$i] ne "functionsListing.json") {
		if ($i == @FILES-1) {
			print MYFILE "\t\t\"NVSEFunctions/$FILES[$i]\"";
		} else {
			print MYFILE "\t\t\"NVSEFunctions/$FILES[$i]\",\n";
		}
	}
}
print MYFILE "\n\t]\n}";