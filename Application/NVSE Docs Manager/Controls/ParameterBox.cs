using System;
using System.Linq;
using System.Windows.Forms;
using NVSE_Docs_Manager.Classes;
using NVSE_Docs_Manager.Windows;

namespace NVSE_Docs_Manager.Controls
{
	public partial class ParameterBox : UserControl
	{
		public string Title
		{
			set { groupBoxParameter.Text = value; }
		}

		public string Url
		{
			get { return comboBoxParameterURL.Text; }
			private set { comboBoxParameterURL.Text = value; }
		}

		public string Type
		{
			get { return comboBoxParameterType.Text; }
			private set { comboBoxParameterType.Text = value; }
		}

		public string TypeName
		{
			get { return comboBoxParameterName.Text; }
			private set { comboBoxParameterName.Text = value; }
		}

		public string Value
		{
			get { return comboBoxParameterValue.Text; }
			private set { comboBoxParameterValue.Text = value; }
		}

		public string Optional { 
			get { return checkBoxParameterOptional.Checked.ToString().ToLower(); }
			private set { checkBoxParameterOptional.Checked = Convert.ToBoolean(value); }
		}

		public object[] UrlBoxContents
		{
			get
			{
				var s = new object[comboBoxParameterURL.Items.Count];
				for (int index = 0; index < comboBoxParameterURL.Items.Count; index++)
				{
					s[index] = comboBoxParameterURL.Items[index].ToString();
				}
				return s;
			}
			set { comboBoxParameterURL.Items.AddRange(value); }
		}
		public object[] ValueBoxContents
		{
			get
			{
				var s = new object[comboBoxParameterValue.Items.Count];
				for (int index = 0; index < comboBoxParameterValue.Items.Count; index++)
				{
					s[index] = comboBoxParameterValue.Items[index].ToString();
				}
				return s;
			}
			set { comboBoxParameterValue.Items.AddRange(value); }
		}
		public object[] TypeBoxContents
		{
			get
			{
				var s = new object[comboBoxParameterType.Items.Count];
				for (int index = 0; index < comboBoxParameterType.Items.Count; index++)
				{
					s[index] = comboBoxParameterType.Items[index].ToString();
				}
				return s;
			}
			set { comboBoxParameterType.Items.AddRange(value); }
		}
		public object[] NameBoxContents
		{
			get
			{
				var s = new object[comboBoxParameterName.Items.Count];
				for (int index = 0; index < comboBoxParameterName.Items.Count; index++)
				{
					s[index] = comboBoxParameterName.Items[index].ToString();
				}
				return s;
			}
			set { comboBoxParameterName.Items.AddRange(value); }
		}

		private readonly ToolTip _ttip = new ToolTip()
		{
			InitialDelay = 100
		};

		#region Constructors

			public ParameterBox()
			{
				InitializeComponent();
				SetComboBoxContents();
			}

			/// <summary>
			/// Create a new parameter from a ParameterDef object
			/// </summary>
			/// <param name="parameter">The new parameter from which to make a parameter panel.</param>
			public ParameterBox(ParameterDef parameter)
			{
				InitializeComponent();
				Url = parameter.Url;
				Type = GetType(parameter.Type);
				TypeName = GetName(parameter.Type);
				Value = parameter.Value;
				Optional = parameter.Optional;
				SetComboBoxContents();
			}

			/// <summary>
			/// Copies one ParameterBox to a new one
			/// </summary>
			/// <param name="toCopy">ParameterBox Control to be copied</param>
			public ParameterBox(ParameterBox toCopy)
			{
				InitializeComponent();
				Url = toCopy.Url;
				Type = toCopy.Type;
				TypeName = toCopy.TypeName;
				Optional = toCopy.Optional;
				Value = toCopy.Value;
				UrlBoxContents = toCopy.UrlBoxContents;
				ValueBoxContents = toCopy.ValueBoxContents;
				TypeBoxContents = toCopy.TypeBoxContents;
				NameBoxContents = toCopy.NameBoxContents;
			}
		#endregion

		/// <summary>
		/// Gets the combo box value arrays from the variables class.
		/// </summary>
		private void SetComboBoxContents()
		{
			UrlBoxContents = Variables.GetUrlObjectArray();
			ValueBoxContents = Variables.GetValueObjectArray();
			TypeBoxContents = Variables.GetTypeObjectArray();
			NameBoxContents = Variables.GetNameObjectArray();
		}

		/// <summary>
		/// Converts the parameter box data to a parameter def
		/// </summary>
		/// <returns>Box data as a ParameterDef</returns>
		public ParameterDef ToParameterDef()
		{
			var newParam = new ParameterDef
			{
				Url = String.IsNullOrWhiteSpace(Url) ? null : Url,
				Type = String.IsNullOrEmpty(Type) && String.IsNullOrEmpty(TypeName) ? null : (Type + ":" + TypeName),
				Value = String.IsNullOrEmpty(Value) ? null : comboBoxParameterValue.Text,
				Optional = Optional.Equals("true", StringComparison.OrdinalIgnoreCase) ? Optional : null
			};

			return newParam;
		}

		#region Getters/Setters

			private string GetType(string type)
			{
				if (type == null) return null;

				var s = type.Split(':');
				return s.Length >= 1 ? s[0] : "";
			}

			private string GetName(string type)
			{
				if (type == null) return null;

				var s = type.Split(':');
				return s.Length >= 2 ? s[1] : "";
			}

		#endregion

		#region Event Handlers
			private void RemoveParameter_Click(object sender, System.EventArgs e)
			{
				var groupbox = ((Button)sender).Parent;
				var parameterbox = ((GroupBox)groupbox).Parent;
				var flowbox = ((ParameterBox)parameterbox).Parent;
				flowbox.Controls.Remove(this);
			}

			private void CopyParameter_Click(object sender, System.EventArgs e)
			{
				Control copy = new ParameterBox(this);
				var groupbox = ((Button) sender).Parent;
				var parameterbox = ((GroupBox) groupbox).Parent;
				var flowbox = ((ParameterBox) parameterbox).Parent;

				flowbox.Controls.Add(copy);
				flowbox.Controls.SetChildIndex(copy, flowbox.Controls.GetChildIndex(this) + 1);

				// Hacky workaround to make the list reorder numbers correctly after changing index above
				var temp = new ParameterBox();
				flowbox.Controls.Add(temp);
				flowbox.Controls.Remove(temp);
			}
		#endregion

			
	}
}
