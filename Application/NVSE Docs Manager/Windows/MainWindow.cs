using System;
using System.Collections.Generic;
using System.Drawing;
using System.IO;
using System.Linq;
using System.Windows.Forms;
using Newtonsoft.Json;
using NVSE_Docs_Manager.Classes;
using NVSE_Docs_Manager.Controls;
using Formatting = Newtonsoft.Json.Formatting;

namespace NVSE_Docs_Manager.Windows
{

	public delegate void Update();

	public partial class MainWindow : Form
	{
		/// <summary>
		/// Instance of the Exampel Window used to ensure only one window exists.
		/// </summary>
		ExamplesWindow _exampleWindowInstance = null;

		/// <summary>
		/// The name of the first file we opened.
		/// </summary>
		string _fileName;

		public MainWindow()
		{
			InitializeComponent();
			comboBoxReturnTypeURL.Items.AddRange(Variables.GetUrlObjectArray());
		}

		private void CreateFunctionFromWiki()
		{
			var newParameter = new WikiParser(richTextBoxDescription.Text).GetFunction();

			PopulateFunctionForm(new FunctionDef());
			PopulateFunctionForm(newParameter);
			UpdateParameterLists();
			RebuildParamaterPanel();
		}

		/// <summary>
		/// Turns a json encoded StreamReader file object into a list of FunctionDef objects.
		/// </summary>
		/// <param name="file">An input file object formatted in json.</param>
		private void ParseLoadedFile(StreamReader file)
		{
			PopulateFunctionListBox(JsonConvert.DeserializeObject<List<FunctionDef>>(file.ReadToEnd()));
			UpdateParameterLists();
		}

		/// <summary>
		/// Updates the ParameterDef type and name lists from all parameters
		/// </summary>
		public void UpdateParameterLists()
		{
			Variables.UpdateLists();
			comboBoxReferenceType.Items.Clear();
			comboBoxReferenceType.Items.AddRange(Variables.GetReferenceObjectArray());
			comboBoxReturnTypeURL.Items.Clear();
			comboBoxReturnTypeURL.Items.AddRange(Variables.GetUrlObjectArray());
			comboBoxReturnTypeType.Items.Clear();
			comboBoxReturnTypeType.Items.AddRange(Variables.GetTypeObjectArray());
			comboBoxReturnTypeName.Items.Clear();
			comboBoxReturnTypeName.Items.AddRange(Variables.GetNameObjectArray());
			comboBoxReturnTypeValue.Items.Clear();
			comboBoxReturnTypeValue.Items.AddRange(Variables.GetValueObjectArray());
		}

		/// <summary>
		/// Takes a list of function objects and adds their names to the listbox form.
		/// </summary>
		/// <param name="functionList">A List of FunctionDefs that will be added to the working list of functions.</param>
		private void PopulateFunctionListBox(IEnumerable<FunctionDef> functionList)
		{
			if (functionList != null)
				foreach (FunctionDef f in functionList)
					AddToFunctionListBox(f);
			RebuildParamaterPanel();
		}

		/// <summary>
		/// Checks if a function exists in the list and, if it's not, adds it to the list and updates the listbox
		/// </summary>
		/// <param name="functionToAdd">A function to add to the list of loaded functions</param>
		private void AddToFunctionListBox(FunctionDef functionToAdd)
		{
			if (Variables.FunctionExists(functionToAdd)) return;
			listboxFunctionList.Items.Add(functionToAdd.Name);
			Variables.AddFunction(functionToAdd);
		}

		/// <summary>
		/// Resets the entire form to the state of program start
		/// </summary>
		private void ClearEntireForm()
		{
			if (listboxFunctionList != null) listboxFunctionList.Items.Clear();
			if (flowLayoutPanelParameters != null) flowLayoutPanelParameters.Controls.Clear();
			textBoxName.Clear();
			textBoxAlias.Clear();
			textBoxVersion.Clear();
			textBoxOrigin.Clear();
			comboBoxReferenceType.SelectedIndex = -1;
			textBoxTags.Clear();
			richTextBoxDescription.Clear();
			radioButtonCallingConventionEither.Checked = true;
			checkBoxReturnType.Checked = false;
			checkBoxConditional.Checked = false;
		}

	#region Function Panel

		#region Events
			/// <summary>
			/// Enables the Save button only when a function name has been entered
			/// </summary>
			private void textBoxName_TextChanged(object sender, EventArgs e)
			{
				var t = (TextBox)sender;
				if (String.IsNullOrEmpty(t.Text) || String.IsNullOrWhiteSpace(t.Text))
					buttonSaveCurrentChanges.Enabled = false;
				else
					buttonSaveCurrentChanges.Enabled = true;
			}

			private void buttonNewParameter_Click(object sender, EventArgs e)
			{
				flowLayoutPanelParameters.Controls.Add(new ParameterBox());
				RebuildParamaterPanel();
			}

			/// <summary>
			/// Toggles the fields in the return type group.
			/// </summary>
			private void checkBoxReturnType_CheckedChanged(object sender, EventArgs e)
			{
				var box = (CheckBox)sender;

				foreach (Control c in from Control c in box.Parent.Controls where c != box select c)
				{
					c.Enabled = c.Enabled != true;
				}
			}

			/// <summary>
			/// Save all the form data and add the function as a new function to the list box
			/// </summary>
			private void buttonSaveCurrentChanges_Click(object sender, EventArgs e)
			{
				if (Variables.FunctionExists(textBoxName.Text))
				{
					if (Common.ConfirmUpdateFunction())
						UpdateCurrentFunction();
				}
				else
					SaveNewFunction();

				UpdateParameterLists();
			}

		/// <summary>
			/// Reverts changes to the state when the form was loaded
			/// If working at start, will produce a clean form
			/// If working on an existing function will revert to pre-edit
			/// </summary>
			private void buttonDiscardChanges_Click(object sender, EventArgs e)
			{
				if (Common.ConfirmDiscardChanges())
					if (Variables.IsBackupNull())
						PopulateFunctionForm(new FunctionDef());
					else
						PopulateFunctionForm(Variables.GetBackup());
			}

			/// <summary>
			/// Prompts to ensure the user wants to clear the form, then clears all form entry if yes
			/// </summary>
			private void buttonNewFunction_Click(object sender, EventArgs e)
			{
				if (convertWikiPagesToolStripMenuItem.Checked == true)
					CreateFunctionFromWiki();
				else
				{
					if (Common.ConfirmClearForm())
						PopulateFunctionForm(new FunctionDef());
				}
				
			}

			private void buttonShowExamples_Click(object sender, EventArgs e)
			{
				if (_exampleWindowInstance == null || _exampleWindowInstance.IsDisposed)
				{
					_exampleWindowInstance = new ExamplesWindow();
					_exampleWindowInstance.PopulateForm();
				}
				_exampleWindowInstance.Show();

				if (_exampleWindowInstance.Focused == false)
					_exampleWindowInstance.Focus();
			}

			private void flowLayoutPanelParameters_ControlAdded(object sender, ControlEventArgs e)
			{
				RebuildParamaterPanel();
			}

			private void flowLayoutPanelParameters_ControlRemoved(object sender, ControlEventArgs e)
			{
				RebuildParamaterPanel();
			}
		#endregion Events

		/// <summary>
		/// Takes a function and fills in all the window fields
		/// with their appropriate data
		public void PopulateFunctionForm(FunctionDef func)
		{
			flowLayoutPanelParameters.Controls.Clear();
			textBoxName.Clear();
			textBoxAlias.Clear();
			textBoxVersion.Clear();
			textBoxOrigin.Clear();
			textBoxTags.Clear();
			comboBoxReferenceType.SelectedIndex = -1;
			richTextBoxDescription.Clear();
			radioButtonCallingConventionEither.Checked = true;
			checkBoxReturnType.Checked = false;
			checkBoxConditional.Checked = false;

			// save the settings to a global first, so we can revert if a bad change is made
			Variables.SetBackup(func);
			Variables.SetExampleList(func.ExampleList);

			if (_exampleWindowInstance != null)
				_exampleWindowInstance.PopulateForm();

			textBoxName.Text = func.Name;
			textBoxAlias.Text = func.Alias;
			textBoxVersion.Text = func.Version;
			textBoxOrigin.Text = func.FromPlugin;
			comboBoxReferenceType.Text = func.ReferenceType;

			if (func.Tags != null)
				foreach (string s in func.Tags) 
					textBoxTags.Text += s + System.Environment.NewLine;

			switch (func.Convention)
			{
				case "B": radioButtonCallingConventionBase.Checked = true; break;
				case "E": radioButtonCallingConventionEither.Checked = true; break;
				case "R": radioButtonCallingConventionRef.Checked = true; break;
				default: radioButtonCallingConventionEither.Checked = true; break;
			}

			// TODO: Change from Yes/No to T/F or Y/N and update javascript to match
			switch (func.Condition)
			{
				case "True": checkBoxConditional.Checked = true; break;
				default: checkBoxConditional.Checked = false; break;
			}

			PopulateParameterList(func.Parameters);

			switch (func.ReturnType == null)
			{
				case true:
					comboBoxReturnTypeURL.Text = "";
					comboBoxReturnTypeType.Text = "";
					comboBoxReturnTypeName.Text = "";
					comboBoxReturnTypeValue.Text = "";
					checkBoxReturnType.Checked = false;
					break;
				default:
					comboBoxReturnTypeURL.Text = func.ReturnType[0].Url;
					var s = func.ReturnType[0].Type.Split(':');
					if (s.Length >= 1) { comboBoxReturnTypeType.Text = s[0]; }
					if (s.Length >= 2) { comboBoxReturnTypeName.Text = s[1]; }
					comboBoxReturnTypeValue.Text = func.ReturnType[0].Value;
					checkBoxReturnType.Checked = true;
					break;
			}

			if (func.Description != null)
				foreach (var s in func.Description)
					richTextBoxDescription.Text += System.Web.HttpUtility.HtmlDecode(s) + System.Environment.NewLine +
					                               System.Environment.NewLine;
		}

		/// <summary>
		/// Creates a ParameterDef list and populates all the groupboxes with
		/// the values from a function's parameters
		/// </summary>
		/// <param name="paramList">List of parameters</param>
		private void PopulateParameterList(IEnumerable<ParameterDef> parameterList)
			{
				if (parameterList != null)
				{
					foreach (ParameterDef parameter in parameterList)
					{
						Control c = new ParameterBox(parameter);

						//Variables.ParametersList.Add(c);
						flowLayoutPanelParameters.Controls.Add(c);
					}
					RebuildParamaterPanel();
				}
			}

		/// <summary>
		/// Renumbers the groupbox text on all groupboxes in the ParameterDef list
		/// </summary>
		public void RebuildParamaterPanel()
		{
			for (int i = 0; i < flowLayoutPanelParameters.Controls.Count; i++)
				((ParameterBox)flowLayoutPanelParameters.Controls[i]).Title = "Parameter " + (i + 1);
		}

		/// <summary>
		/// Converts the window data into a function object
		/// </summary>
		/// <param name="function">A function that will be returned filled with the data in the window.</param>
		private FunctionDef WindowToFunction(FunctionDef function)
		{
		// NAME
			if (!String.IsNullOrEmpty(textBoxName.Text))
				function.Name = textBoxName.Text;

		// ALIAS
			function.Alias = String.IsNullOrEmpty(textBoxAlias.Text) ? null : textBoxAlias.Text;

		// VERSION 
			function.Version = String.IsNullOrEmpty(textBoxVersion.Text) ? null : textBoxVersion.Text;

		// ORIGIN
			function.FromPlugin = String.IsNullOrEmpty(textBoxOrigin.Text) ? null : textBoxOrigin.Text;

		// REFERENCE TYPE
			function.ReferenceType = String.IsNullOrEmpty(comboBoxReferenceType.Text) ? null : comboBoxReferenceType.Text;

		// TAGS
			if (!String.IsNullOrEmpty(textBoxTags.Text))
			{
				// if the tag variable is null, and there are tags to put in it, create a new list
				if (function.Tags == null)
					function.Tags = new List<string>();

				// step through each line in the text box, each line is a tag, and store each one
				// in the list. If there is an empty line, or the line exists already, skip it.
				foreach (var line in textBoxTags.Lines.Where(line => function.Tags.IndexOf(line) == -1 && !String.IsNullOrEmpty(line)))
				{
					function.Tags.Add(line);
				}
			}

		// CALLING CONVENTION
			if (radioButtonCallingConventionBase.Checked == true) 
				function.Convention = "B";
			else if (radioButtonCallingConventionEither.Checked == true)
				function.Convention = "E";
			else if (radioButtonCallingConventionRef.Checked == true)
				function.Convention = "R";


			// TODO: Update javascript to handle true/false
			function.Condition = checkBoxConditional.Checked == true ? checkBoxConditional.Checked.ToString() : null;

		// PARAMETERS
			function.Parameters = MakeParameterList();

		// RETURN TYPE
			if (checkBoxReturnType.Checked)
			{
				if (function.ReturnType == null)
					function.ReturnType = new List<ReturnTypeDef> {new ReturnTypeDef()};

				if (!String.IsNullOrEmpty(comboBoxReturnTypeURL.Text) && !String.IsNullOrWhiteSpace(comboBoxReturnTypeURL.Text)) 
					function.ReturnType[0].Url = comboBoxReturnTypeURL.Text;

				var s = comboBoxReturnTypeType.Text + ":" + comboBoxReturnTypeName.Text;
				if (!String.IsNullOrEmpty(s))
					function.ReturnType[0].Type = s;

				if (!String.IsNullOrEmpty(comboBoxReturnTypeValue.Text))
					function.ReturnType[0].Value = comboBoxReturnTypeValue.Text;
			}

		// EXAMPLES
			if (!Variables.IsExampleListNull())
				function.ExampleList = Variables.GetExampleList();

		// DESCRIPTION
			if (!String.IsNullOrEmpty(richTextBoxDescription.Text))
			{
				if (function.Description == null) 
					function.Description = new List<string>();

				function.Description.Clear();
				foreach (var line in richTextBoxDescription.Lines)
				{
					if (function.Description.IndexOf(line) == -1 && !String.IsNullOrEmpty(line))
						function.Description.Add(System.Web.HttpUtility.HtmlEncode(line));
				}
			}

			return function;
		}

		/// <summary>
		/// Builds a list of parameter defs from the flowLayoutPanelParameters
		/// </summary>
		/// <returns>Returns a list of ParameterDefs</returns>
		private List<ParameterDef> MakeParameterList()
		{
			if (flowLayoutPanelParameters.Controls.Count > 0)
				return (from ParameterBox c in flowLayoutPanelParameters.Controls select c.ToParameterDef()).ToList();
			return null;
		}

		/// <summary>
		/// Takes all the info in the window and creates a new function from it
		/// then adds it to the listbox and Variables.LoadedFunctionsList
		/// </summary>
		private void SaveNewFunction()
		{
			var func = WindowToFunction(new FunctionDef());
			AddToFunctionListBox(func);
		}

		/// <summary>
		/// Finds the current function by name and replaces its data with that in the window
		/// </summary>
		private void UpdateCurrentFunction()
		{
			WindowToFunction(Variables.GetFunctionList().Find(f => f.Name == textBoxName.Text));
		}

	#endregion

	#region Function List

		#region Events
			/// <summary>
			/// Uses MouseUp event to catch when the selcted count changes.
			/// Checks how many are selected and enables the editing buttons.
			/// </summary>
			private void listboxFunctionList_MouseUp(object sender, MouseEventArgs e)
			{
				if (listboxFunctionList.SelectedItem != null)
				{
					if (listboxFunctionList.SelectedItems.Count > 1)
					{
						buttonListBoxDeleteItem.Enabled = true;
						buttonBatchTag.Enabled = true;
						buttonBatchVersion.Enabled = true;
						buttonBatchOrigin.Enabled = true;
					}
					else
					{
						buttonListBoxDeleteItem.Enabled = true;
						buttonBatchTag.Enabled = false;
						buttonBatchVersion.Enabled = false;
						buttonBatchOrigin.Enabled = false;
					}
				}
			}

			/// <summary>
			/// On double click a name in the list box, load the function data into the fields
			/// </summary>
			private void listboxFunctionList_MouseDoubleClick(object sender, MouseEventArgs e)
			{
				LoadSelectedFunction();
			}

			/// <summary>
			/// Delete the selected functions from the functions list and listbox
			/// </summary>
			private void buttonListBoxDeleteItem_Click(object sender, EventArgs e)
			{
				if (listboxFunctionList.SelectedItems.Count > 0)
				{
					if (Common.ConfirmDelete("function(s)"))
					{
						Variables.RemoveFunction(listboxFunctionList.SelectedItems);
						for (int i = listboxFunctionList.SelectedItems.Count - 1; i >= 0; i--)
							listboxFunctionList.Items.Remove(listboxFunctionList.SelectedItems[i]);
					}
				}
			}

			/// <summary>
			/// Handles key presses for listboxFunctionList
			/// </summary>
			private void listboxFuctionList_KeyUp(object sender, KeyEventArgs e)
		{
			switch (e.KeyCode)
			{
				case Keys.Delete:
					buttonListBoxDeleteItem_Click(sender, e);
					break;
				case Keys.Enter:
					LoadSelectedFunction();
					break;
				default:

					break;
			}
		}

			/// <summary>
			/// Bulk add a new tag of all selected functions.
			/// </summary>
			private void buttonBatchTag_Click(object sender, EventArgs e)
			{
				var input = "";
				var d = Common.InputBox("Add Tag", "Enter ONE tag to add:", ref input);
				if (d)
					Variables.UpdateTags(listboxFunctionList.SelectedItems, input);
			}
			
			/// <summary>
			/// Bulk change the version of all selected functions
			/// </summary>
			private void buttonBatchVersion_Click(object sender, EventArgs e)
			{
				var input = "";
				var d = Common.InputBox("Add Tag", "Enter the new version:", ref input);
				if (d)
					Variables.UpdateVersions(listboxFunctionList.SelectedItems, input);
			}

			/// <summary>
			/// Bulk change the origin of all selected functions
			/// </summary>
			private void buttonBatchOrigin_Click(object sender, EventArgs e)
			{
				var input = "";
				var d = Common.InputBox("Add Tag", "Enter the origin plugin:", ref input);
				if (d)
					Variables.UpdateOrigins(listboxFunctionList.SelectedItems, input);
			}

			private void listBox1_DrawItem(object sender, DrawItemEventArgs e)
			{
				bool isSelected = ((e.State & DrawItemState.Selected) == DrawItemState.Selected);

				if (e.Index > -1)
				{
					/* If the item is selected set the background color to SystemColors.Highlight 
					 or else set the color to either WhiteSmoke or White depending if the item index is even or odd */
					var color = isSelected ? SystemColors.Highlight :
						e.Index % 2 == 0 ? Color.WhiteSmoke : Color.White;

					// Background item brush
					var backgroundBrush = new SolidBrush(color);
					// Text color brush
					var textBrush = new SolidBrush(e.ForeColor);

					// Draw the background
					e.Graphics.FillRectangle(backgroundBrush, e.Bounds);
					// Draw the text
					e.Graphics.DrawString(listboxFunctionList.Items[e.Index].ToString(), e.Font, textBrush, e.Bounds, StringFormat.GenericDefault);

					// Clean up
					backgroundBrush.Dispose();
					textBrush.Dispose();
				}
				e.DrawFocusRectangle();
			}
		#endregion

		/// <summary>
		/// Loads the function data from the selected index by name
		/// </summary>
		private void LoadSelectedFunction()
		{
			if (listboxFunctionList.SelectedItem != null)
				PopulateFunctionForm(Variables.GetFunctionByName(listboxFunctionList.SelectedItem.ToString()));
		}

	#endregion Function List

	#region Events
		#region Mouse Event Handlers
			private void flowLayoutPanelParameter_MouseEnter(object sender, EventArgs e)
			{
				flowLayoutPanelParameters.Focus();
			}

			private void listboxFunctionList_MouseLeave(object sender, EventArgs e)
			{
				listboxFunctionList.Focus();
			}
		#endregion

		#region Tool Strip Handlers

		private void openFileToolStripMenuItem_Click(object sender, EventArgs e)
		{
			openFileDialog1.Filter = @"Json Files (.json)|*.json|Text Files(*.*)|*.*";
			openFileDialog1.Multiselect = true;
			switch (openFileDialog1.ShowDialog())
			{
				case DialogResult.OK:
					ClearEntireForm();
					foreach (var sr in openFileDialog1.FileNames.Select(file => new StreamReader(file)))
					{
						ParseLoadedFile(sr);
						sr.Close();
					}
					_fileName = openFileDialog1.SafeFileName;
					break;
			}
		}

		private void saveFileToolStripMenuItem_Click(object sender, EventArgs e)
		{
			saveFileDialog1.Filter = @"Json Files (.json)|*.json|Text Files(*.*)|*.*";
			saveFileDialog1.FileName = _fileName;
			switch (saveFileDialog1.ShowDialog())
			{
				case DialogResult.OK:
				{
					var sw = new StreamWriter(saveFileDialog1.OpenFile());
					var settings = new JsonSerializerSettings()
					{
						Formatting = Formatting.None,
						DefaultValueHandling = DefaultValueHandling.Ignore,
						NullValueHandling = NullValueHandling.Ignore,
					};

					if (outputReadableFileToolStripMenuItem.Checked == true)
						settings.Formatting = Formatting.Indented;

					Variables.CleanFunctionList();
					sw.Write(JsonConvert.SerializeObject(Variables.GetFunctionList(), settings));
					sw.Close();
				}
					break;
			}
		}

		private void resetToolStripMenuItem_Click(object sender, EventArgs e)
		{
			ClearEntireForm();
		} 

		private void exitToolStripMenuItem_Click(object sender, EventArgs e)
		{
			if (Common.ConfirmCloseForm())
				Application.Exit();
		}

		private void checkToolStripMenuItem_Click(object sender, EventArgs e)
		{
			switch (((ToolStripMenuItem)sender).Checked)
			{
				case true:
					((ToolStripMenuItem)sender).Checked = false;
					break;
				default:
					((ToolStripMenuItem)sender).Checked = true;
					break;
			}
		}

		private void aboutToolStripMenuItem_Click(object sender, EventArgs e)
		{
			var aw = new AboutWindow();
			aw.ShowDialog();
		}

		private void howToUseThisToolStripMenuItem_Click(object sender, EventArgs e)
		{

		}

		private void toolStripMenuItemExportNotepadFiles_Click(object sender, EventArgs e)
		{
			var swNvse = new StreamWriter("Notepad++ NVSE Functions.txt");
			var swMods = new StreamWriter("Notepad++ Mod Functions.txt");

			foreach (var fd in Variables.GetFunctionList())
			{
				if (String.IsNullOrEmpty(fd.FromPlugin))
				{
					swNvse.Write(fd.Name + Environment.NewLine);
					if (!String.IsNullOrEmpty(fd.Alias))
						swNvse.Write(fd.Alias + Environment.NewLine);
				}
				else
				{
					swMods.Write(fd.Name + Environment.NewLine);
					if (!String.IsNullOrEmpty(fd.Alias))
						swMods.Write(fd.Alias + Environment.NewLine);
				}
			}
			swNvse.Close();
			swMods.Close();
		}

		private void typeCodesEditorToolStripMenuItem_Click(object sender, EventArgs e)
		{
			var window = new TypeCodesEditor();
			window.ShowDialog();
		}

		private void wikiDataToolStripMenuItem_Click(object sender, EventArgs e)
		{
			var exeRuntimeDirectory = System.IO.Path.GetDirectoryName(System.Reflection.Assembly.GetExecutingAssembly().Location);

			if (!Directory.Exists(exeRuntimeDirectory + "\\Wiki Data"))
				Directory.CreateDirectory(exeRuntimeDirectory + "\\Wiki Data");

			foreach (var fd in Variables.GetFunctionList())
			{
				var filepath = exeRuntimeDirectory + "\\Wiki Data\\" + fd.Name + ".txt";
				var sw = new StreamWriter(filepath);

				var output = "{{Function" + Environment.NewLine;

				output += " |origin = ";
				output += String.IsNullOrEmpty(fd.FromPlugin) ? "NVSE" : fd.FromPlugin;
				output += Environment.NewLine;

				output += " |summary = ";
				output =
					System.Web.HttpUtility.HtmlDecode(fd.Description.Aggregate(output, (current, line) => current + (line + " ")));
				output += Environment.NewLine;

				output += " |name = ";
				output += fd.Name;
				output += Environment.NewLine;

				if (!String.IsNullOrEmpty(fd.Alias))
				{
					output += " |alias = ";
					output += fd.Alias;
					output += Environment.NewLine;
				}

				if (fd.ReturnType != null)
				{
					if (!String.IsNullOrEmpty(fd.ReturnType[0].Value))
					{
						output += " |returnVal = ";
						output += fd.ReturnType[0].Value;
						output += Environment.NewLine;
					}

					if (!String.IsNullOrEmpty(fd.ReturnType[0].Type.Split(':')[0]))
					{
						output += " |returnType = ";
						output += fd.ReturnType[0].Type.Split(':')[0];
						output += Environment.NewLine;
					}
					else output += " |returnType = void" +  Environment.NewLine;
				}
				else output += " |returnType = none" + Environment.NewLine;

				
				if (!String.IsNullOrEmpty(fd.ReferenceType))
				{
					output += " |referenceType = ";
					output += fd.ReferenceType;
					output += Environment.NewLine;
				}

				if (fd.Parameters != null)
				{
					output += " |arguments = " + Environment.NewLine;
					output += "  {{FunctionArgument" + Environment.NewLine;

					for (int index = 0; index < fd.Parameters.Count; index++)
					{
						var fa = fd.Parameters[index];
						output += "   |Name = " + fa.Type.Split(':')[1] + Environment.NewLine;
						output += "   |Type = " + fa.Type.Split(':')[0] + Environment.NewLine;
						if (!String.IsNullOrEmpty(fa.Value))
							output += "   |Value = " + fa.Value + Environment.NewLine;

						if (!String.IsNullOrEmpty(fa.Optional))
							output += "   |Optional = y" + Environment.NewLine;

						output += index < fd.Parameters.Count - 1
							? "  }}{{FunctionArgument" + Environment.NewLine
							: "  }}" + Environment.NewLine;

					}
				}

				if (fd.ExampleList != null)
				{
					output += " |example = ";
					output += fd.ExampleList.ToString();
					output += Environment.NewLine;
				}

				output += "}}";

				output += Environment.NewLine + Environment.NewLine + "==See Also==" + Environment.NewLine;

				output += "[[Category:Functions_(NVSE)]]";

				sw.Write(output);
				sw.Close();
			}
		}

		/// <summary>
		/// When closing the form, ask if data has been saved before allowing an exit
		/// </summary>
		private void mainMenu_FormClosing(object sender, FormClosingEventArgs e)
		{
//#if !DEBUG
//			if (Common.ConfirmCloseForm())
//				e.Cancel = true;
//#endif
		}
		#endregion

		private void listboxSearch_KeyUp(object sender, KeyEventArgs e)
		{
			List<FunctionDef> matches;
			switch (e.KeyCode)
			{
				case Keys.Enter:
					LoadSelectedFunction();
					break;
				case Keys.Down:
					// For each letter typed, find a list with all functions with a matching substring and return it in alphabetical order
					matches =
							Variables.GetFunctionList()
								.Where(s => s.Name.ToLower().Contains(textBoxSearch.Text))
								.OrderBy(f => f.Name)
								.ToList();

					// The first item in the list is the one we want to select

					// Get the currently selected item from the listbox and find it in the list of matches
					var toSelect = matches.Find(f => f.Name.Equals(listboxFunctionList.SelectedItem.ToString())) ?? matches.First();

					// If the next index is out of bounds, set to the last item, otherwise increment one item
					toSelect = matches.IndexOf(toSelect) + 1 < matches.Count ? matches[matches.IndexOf(toSelect) + 1] : matches.Last();

					if (listboxFunctionList.Items.Count > 0)
					{
						listboxFunctionList.SelectedIndex = -1;
						listboxFunctionList.SelectedIndex = listboxFunctionList.Items.IndexOf(toSelect.Name);
					}

					break;
				case Keys.Up:
					try
					{
						// For each letter typed, find a list with all functions with a matching substring and return it in alphabetical order
						matches =
							Variables.GetFunctionList()
								.Where(s => s.Name.ToLower().Contains(textBoxSearch.Text))
								.OrderBy(f => f.Name)
								.ToList();

						// The first item in the list is the one we want to select

						// Get the currently selected item from the listbox and find it in the list of matches
						toSelect = matches.Find(f => f.Name.Equals(listboxFunctionList.SelectedItem.ToString())) ?? matches.First();

						// If the next index is out of bounds, set to the first item, otherwise decrement one item
						toSelect = matches.IndexOf(toSelect) - 1 < 0 ? matches.First() : matches[matches.IndexOf(toSelect) - 1];

						if (listboxFunctionList.Items.Count > 0)
						{
							listboxFunctionList.SelectedIndex = -1;
							listboxFunctionList.SelectedIndex = listboxFunctionList.Items.IndexOf(toSelect.Name);
						}
					}
					catch (InvalidOperationException)
					{ }

					break;
				default:
					try
					{
						// For each letter typed, find a list with all functions with a matching substring and return it in alphabetical order
						matches = Variables.GetFunctionList().Where(s => s.Name.ToLower().Contains(textBoxSearch.Text)).OrderBy(f => f.Name).ToList();

						// The first item in the list is the one we want to select
						toSelect = matches.First();

						if (listboxFunctionList.Items.Count > 0)
						{
							listboxFunctionList.SelectedIndex = -1;
							listboxFunctionList.SelectedIndex = listboxFunctionList.Items.IndexOf(toSelect.Name);
						}
					}
					catch (InvalidOperationException)
					{ }
					break;
			}
		}
	#endregion Events


	}
}

