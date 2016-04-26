using System;
using System.Collections.Generic;
using System.Collections.Specialized;
using System.Configuration;
using System.Linq;
using System.Windows.Forms;
using NVSE_Docs_Manager.Properties;

namespace NVSE_Docs_Manager.Windows
{
	public partial class TypeCodesEditor : Form
	{
		public TypeCodesEditor()
		{
			InitializeComponent();
			foreach (var s in Settings.Default.TypeCodes)
			{
				textBox.Text += s + Environment.NewLine;
			}
		}

		private StringCollection GetBoxContents()
		{
			var contents = new List<string>();

			// step through each line in the text box, each line is a tag, and store each one
			// in the list. If there is an empty line, or the line exists already, skip it.
			foreach (var line in textBox.Lines.Where(line => contents.IndexOf(line) == -1))
			{
				contents.Add(line);
			}
			contents.Sort();

			var collection = new StringCollection();
			collection.AddRange(contents.ToArray());
			
			return collection;
		}

		private void buttonOK_Click(object sender, EventArgs e)
		{
			Close();
		}

		private void buttonCancel_Click(object sender, EventArgs e)
		{
			Close();
		}
	}
}
