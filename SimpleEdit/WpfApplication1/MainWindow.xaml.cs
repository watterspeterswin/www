using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Navigation;
using System.Windows.Shapes;
using Microsoft.Win32;


namespace SimpleEditNS
{
    /// <summary>
    /// Interaction logic for MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window
    {
        private static Brush _openForm;
        private static Brush _closedForm;
        private Document _document;

        public MainWindow()
        {
            InitializeComponent();
            textEditBox.IsEnabled = false;
            saveFile.IsEnabled = false;
            _openForm = textEditBox.Background;
            _closedForm = menuBar.Background;
            textEditBox.Background = _closedForm;
        }
        /*
         * ConfirmOverWrite - provides a dialog to ensure that the user doesn't
         * unintentionally overwrite their work in progress by clicking on "New" or "Open"
         * when their document is modified.
         */
        private bool ConfirmOverWrite()
        {
            bool OverWrite = true;
            if (_document != null)
            {
                //Here's where move the text
                _document.Text = textEditBox.Text;

                MessageBoxResult r = MessageBox.Show("You have work in progress\nDo you want to discard your work?", "Please Confirm Action", MessageBoxButton.YesNoCancel);
                if (r != MessageBoxResult.Yes)
                {
                    OverWrite = false;
                }
            }
            return OverWrite;
        }

        private bool ConfirmAbandon()
        {
            bool Abandon = false;
            if (_document == null)
            {
                Abandon = true;
            }
            else if (_document.Dirty == false)
            {
                Abandon = true;
            }
            else if (_document.Dirty == true)
            {
                //Here's where move the text
                _document.Text = textEditBox.Text;

                MessageBoxResult r = MessageBox.Show("You have work in progress\nDo you want exit without saving?", "Please Confirm Action", MessageBoxButton.YesNoCancel);
                if (r == MessageBoxResult.Yes)
                {
                    Abandon = true;
                    _document = null;
                }
            }                            

            return Abandon;
        }


        /*  Windows_Closing is registered as the "Closing" action for the MainWindow
         *  if the document is modified this function prompts the user 
         *  to confirm that they want to abandon their changes 
         */
        private void Windows_Closing(object sender, System.ComponentModel.CancelEventArgs e)
        {
            if (this.ConfirmAbandon())
            {
                e.Cancel = false;  //This means DON'T "cancel the window closing event"
            }
            else
            {
                e.Cancel = true;   //This means "cancel the window closing event"
            }
        }

        /*  menu_exit_Click action...
         *  if the document is modified this function prompts the user 
         *  to confirm that they want to abandon their changes 
         */
        private void menu_exit_Click(object sender, RoutedEventArgs e)
        {
            if (ConfirmAbandon()) 
            {
                Application.Current.Shutdown();
            }
        }


        /*  newFile_Click action...
         *  if the document is modified this function prompts the user 
         *  to confirm that they want to overwrite their changes 
         */
        private void newFile_Click(object sender, RoutedEventArgs e)
        {
            if (ConfirmOverWrite())
            {
                _document = new Document();
                textEditBox.Text = null;
                textEditBox.IsEnabled = true;
                textEditBox.Background = _openForm;
                this.Title = "Untitled";
            }
        }


        /*  openFile_Click action...
         *  if the document is modified this function prompts the user 
         *  to confirm that they want to overwrite their changes 
         */
        private void openFile_Click(object sender, RoutedEventArgs e)
        {
            if (ConfirmOverWrite())
            {
                OpenFileDialog dlg = new OpenFileDialog();
                if (true == dlg.ShowDialog())
                {
                    _document = new Document();
                    if (_document.Open(dlg.FileName))
                    {
                        textEditBox.IsEnabled = true;
                        textEditBox.Background = _openForm;
                        textEditBox.Text = _document.Text;
                        _document.Dirty = false;
                        this.saveFile.IsEnabled = false;
                        this.Title = dlg.FileName;
                    }
                }
            }
        }


        /*  saveFile_Click action...
         *  Only available if the document is modified,
         *  if the document path is not present this function prompts the user 
         *  with a "Save As" dialog
         */
        private void saveFile_Click(object sender, RoutedEventArgs e)
        {
            if (_document != null)
            {
                //Here's where move the text
                _document.Text = textEditBox.Text;
            }

            if (_document.Path == null)
            {
                SaveFileDialog dlg = new SaveFileDialog();
                if (true == dlg.ShowDialog())
                {
                    _document.Path = dlg.FileName;
                }
            }
            if (_document.Path != null)
            {
                if (!_document.Save())
                {
                    MessageBox.Show("couldn't save " + _document.Path.ToString());
                }
                else
                {
                    this.Title = _document.Path;
                }

                this.saveFile.IsEnabled = false;
            }
        }

        /* textEditBox_TextChanged
         * overwrites the document Text property with the new value
         *  
         */
        private void textEditBox_TextChanged(object sender, TextChangedEventArgs e)
        {
            _document.Dirty = true;
            this.saveFile.IsEnabled = true;
        }

        private void textEditBox_TextInput(object sender, TextCompositionEventArgs e)
        {
            _document.Dirty = true;
            this.saveFile.IsEnabled = true;
        }
    }
}
