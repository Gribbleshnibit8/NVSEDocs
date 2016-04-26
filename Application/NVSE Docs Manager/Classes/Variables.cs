using System;
using System.Collections.Generic;
using System.Linq;
using NVSE_Docs_Manager.Properties;

namespace NVSE_Docs_Manager.Classes
{
	public static class Variables
	{

		private static List<Example> ExampleList { get; set; }

		/// <summary>
		/// List of all loaded functions
		/// </summary>
		private static List<FunctionDef> LoadedFunctionsList { get; set; } 

		/// <summary>
		/// Stores the current function prior to any changes
		/// </summary>
		private static FunctionDef CurrentEditingBackup { get; set; }

		/// <summary>
		/// A list of all the reference types used by the loaded functions
		/// </summary>
		private static List<string> ReferenceTypesList { get; set; }

		/// <summary>
		/// A list of all the names from the left-hand side of the ParameterDef type
		/// </summary>
		private static List<string> ParameterTypesList { get; set; } 

		/// <summary>
		/// A list of all the names from the right-hand side of the ParameterDef type
		/// </summary>
		private static List<string> ParameterNamesList { get; set; }

		/// <summary>
		/// The values all parameters that have been loaded or saved.
		/// </summary>
		private static List<string> ParameterValuesList { get; set; } 


		/// <summary>
		/// A list of the URLs as used on the NVSE site page.
		/// </summary>
		private static List<string> ParameterUrlList { get; set; }


		static Variables()
		{
			CurrentEditingBackup = new FunctionDef();
			LoadedFunctionsList = new List<FunctionDef>();
			ReferenceTypesList = new List<string>();
			ExampleList = new List<Example>();
			ParameterTypesList = new List<string>();
			ParameterNamesList = new List<string>();
			ParameterValuesList = new List<string>();
			ParameterUrlList = new List<string>
			{
				" ",
				"Actor_Flags",
				"Actor_Value_Codes",
				"Ammo_Flags",
				"Animation_Codes",
				"Biped_Masks",
				"Biped_Path_Codes",
				"Class_Codes",
				"Combat_Style_Flags",
				"Creature_Type_Codes",
				"Default_Forms",
				"Equip_Codes",
				"Explosion_Flags",
				"Form_Type_IDs",
				"Key_Codes",
				"Light_Codes",
				"Map_Marker_Type",
				"Package_Flags",
				"Perk_Entry",
				"Projectile_Flags",
				"Radio_Broadcast_Type",
				"Sound_Flags",
				"Weapon_Codes",
				"Weather_and_Climate_Codes"
			};
		}


		/// <summary>
		/// Updates the ParameterDef type and name lists from all parameters
		/// </summary>
		public static void UpdateLists()
		{
			foreach (FunctionDef f in LoadedFunctionsList)
			{
				// Reference Types
				if (f.ReferenceType != null)
					if (!ReferenceTypesList.Contains(f.ReferenceType))
						ReferenceTypesList.Add(f.ReferenceType);

				if (f.ReturnType != null)
				{
					foreach (var r in f.ReturnType)
					{
						if (r.Type != null)
						{
							var s = r.Type.Split(':');
							if (!ParameterTypesList.Contains(s[0]) && !String.IsNullOrEmpty(s[0]))
								ParameterTypesList.Add(s[0]);

							if (s.Length >= 2 && !ParameterNamesList.Contains(s[1]) && !String.IsNullOrEmpty(s[1]))
								ParameterNamesList.Add(s[1]);
						}

						if (r.Value != null && !ParameterValuesList.Contains(r.Value))
							ParameterValuesList.Add(r.Value);

						if (r.Url != null && !ParameterUrlList.Contains(r.Url))
							ParameterUrlList.Add(r.Url);
					}
				}

				// Parameters
				if (f.Parameters == null) continue;

				foreach (var p in f.Parameters)
				{
					if (p.Type != null)
					{
						var s = p.Type.Split(':');
						if (!ParameterTypesList.Contains(s[0]) && !String.IsNullOrEmpty(s[0]))
							ParameterTypesList.Add(s[0]);

						if (s.Length >= 2 && !ParameterNamesList.Contains(s[1]) && !String.IsNullOrEmpty(s[1]))
							ParameterNamesList.Add(s[1]);
					}

					if (p.Value != null && !ParameterValuesList.Contains(p.Value))
						ParameterValuesList.Add(p.Value);

					if (p.Url != null && !ParameterUrlList.Contains(p.Url))
						ParameterUrlList.Add(p.Url);
				}
			}
		}



		#region LoadedFunctionLists Functions

		public static bool FunctionExists(FunctionDef toFind)
			{
				if (LoadedFunctionsList.Exists(f => f.Name == toFind.Name))
					return true;
				return false;
			}

			public static bool FunctionExists(string toFind)
			{
				if (LoadedFunctionsList.Exists(f => f.Name == toFind))
					return true;
				return false;
			}

			public static FunctionDef GetFunctionByName(string toFind)
			{
				return LoadedFunctionsList.Find(f => f.Name == toFind);
			}

			/// <summary>
			/// Adds a function definition to the function list.
			/// </summary>
			/// <param name="toAdd">The function definition to add.</param>
			public static bool AddFunction(FunctionDef toAdd)
			{
				if (FunctionExists(toAdd)) return false;
				LoadedFunctionsList.Add(toAdd);
				return true;
			}

			/// <summary>
			/// Returns the function list
			/// </summary>
			public static List<FunctionDef> GetFunctionList()
			{
				return LoadedFunctionsList;
			}

			/// <summary>
			/// Remove a single function from the list
			/// </summary>
			/// <param name="toRemove">FunctionDef item to remove</param>
			public static void RemoveFunction(FunctionDef toRemove)
			{
				LoadedFunctionsList.Remove(LoadedFunctionsList.Find(f => f.Name == toRemove.Name));
			}

			/// <summary>
			/// A list of function items to remove from the function list.
			/// </summary>
			/// <param name="toRemove">A ListBox.SelectedObjectCollection of Function names to remove from the function list.</param>
			public static void RemoveFunction(object toRemove)
			{
				dynamic d = toRemove;
				for (int i = d.Count - 1; i >= 0; i--)
				{
					LoadedFunctionsList.Remove(LoadedFunctionsList.Find(f => f.Name == d[i].ToString()));
				}
			}

			/// <summary>
			/// Updates the tags of all passed items
			/// </summary>
			/// <param name="toUpdate">The list of objects to be updated</param>
			/// <param name="newValue">The value to update to</param>
			public static void UpdateTags(object toUpdate, string newValue)
			{
				dynamic d = toUpdate;
				foreach (string s in d)
				{
					LoadedFunctionsList.Find(f => f.Name == s).Tags.Add(s);
				}
			}

			/// <summary>
			/// Updates the version of all passed items
			/// </summary>
			/// <param name="toUpdate">The list of objects to be updated</param>
			/// <param name="newValue">The value to update to</param>
			public static void UpdateVersions(object toUpdate, string newValue)
			{
				dynamic d = toUpdate;
				foreach (var s in d)
				{
					LoadedFunctionsList.Find(f => f.Name == s).Version = newValue;
				}
			}

			/// <summary>
			/// Updates the origin of all passed items
			/// </summary>
			/// <param name="toUpdate">The list of objects to be updated</param>
			/// <param name="newValue">The value to update to</param>
			public static void UpdateOrigins(object toUpdate, string newValue)
			{
				dynamic d = toUpdate;
				foreach (var s in d)
				{
					LoadedFunctionsList.Find(f => f.Name == s).FromPlugin = newValue;
				}
			}

			public static void CleanFunctionList()
			{
				foreach (var f in LoadedFunctionsList)
				{
					f.CleanFunctionDef();
				}
			}

		#endregion



		#region Backup Properties
			/// <summary>
			/// Sets the current backup field
			/// </summary>
			/// <param name="backup">The function to be saved</param>
			public static void SetBackup(FunctionDef backup)
			{
				CurrentEditingBackup = backup;
			}

			/// <summary>
			/// Gets the current backup field
			/// </summary>
			/// <returns>The last backed up function</returns>
			public static FunctionDef GetBackup()
			{
				return CurrentEditingBackup;
			}

			/// <summary>
			/// Checks if the backup function is valid
			/// </summary>
			/// <returns>True if backup is valid</returns>
			public static bool IsBackupNull()
			{
				return CurrentEditingBackup == null;
			}
			#endregion



		#region Example List Properties

			public static void SetExampleList(List<Example> list)
			{
				ExampleList = list;
			}

			/// <summary>
			/// Returns the example list, clean of all empty examples.
			/// </summary>
			/// <returns>Clean example list.</returns>
			public static List<Example> GetExampleList()
			{
				foreach (var e in ExampleList.Where(e => e.Contents == null))
					ExampleList.Remove(e);
				return ExampleList;
			}

			/// <summary>
			/// Checks whether or not the example list is null.
			/// </summary>
			/// <returns>Returns true if the list is null.</returns>
			public static bool IsExampleListNull()
			{
				return ExampleList == null;
			}

			public static void AddExample()
			{
				if (ExampleList != null) ExampleList.Add(new Example());
				else ExampleList = new List<Example>() {new Example()};
			}

			public static void RemoveExample(int index)
			{
				ExampleList.RemoveAt(index);
			}

			/// <summary>
			/// Updates the example array at the specified index
			/// </summary>
			/// <param name="index">Index to update.</param>
			/// <param name="lines">Array of strings to add</param>
			public static void UpdateExampleAtIndex(int index, string[] lines)
			{
				ExampleList[index].Contents.Clear();
				foreach (var s in lines)
				{
					//ExampleList[index].Contents.Add(System.Web.HttpUtility.HtmlEncode(s));
					ExampleList[index].Contents.Add(s);
				}
			}
			
		#endregion



		#region Lists To Arrays

			/// <summary>
			/// Get an object array of the ParameterUrlList
			/// </summary>
			/// <returns>Object array with the contents of ParameterUrlList</returns>
			public static object[] GetUrlObjectArray()
			{
				// ReSharper disable once CoVariantArrayConversion
				return ParameterUrlList.ToArray();
			}

			/// <summary>
			/// Get an object array of the ParameterTypesList
			/// </summary>
			/// <returns>Object array with the contents of ParameterTypesList</returns>
			public static object[] GetTypeObjectArray()
			{
				// ReSharper disable once CoVariantArrayConversion
				return ParameterTypesList.ToArray();
			}
		
			/// <summary>
			/// Get an object array of the ParameterNamesList
			/// </summary>
			/// <returns>Object array with the contents of ParameterNamesList</returns>
			public static object[] GetNameObjectArray()
			{
				// ReSharper disable once CoVariantArrayConversion
				return ParameterNamesList.ToArray();
			}

			/// <summary>
			/// Get an object array of the ParameterNamesList
			/// </summary>
			/// <returns>Object array with the contents of ParameterNamesList</returns>
			public static object[] GetValueObjectArray()
			{
				// ReSharper disable once CoVariantArrayConversion
				return ParameterValuesList.ToArray();
			}

			/// <summary>
			/// Get an object array of the ReferenceTypesList
			/// </summary>
			/// <returns>Object array with the contents of ReferenceTypesList</returns>
			public static object[] GetReferenceObjectArray()
			{
				// ReSharper disable once CoVariantArrayConversion
				return ReferenceTypesList.ToArray();
			}

		#endregion



	}
}
