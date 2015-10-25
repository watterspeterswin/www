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


namespace WpfApplication1
{
    /// <summary>
    /// Interaction logic for MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window
    {
        public MainWindow()
        {
            InitializeComponent();
            textEditBox.IsEnabled = false;
            saveFile.IsEnabled = false;
        }

        private bool ConfirmOverWrite()
        {
            bool OverWrite = true;
            if (m_Document != null)
            {
                MessageBoxResult r = MessageBox.Show("You have work in progress\nDo you want to discard your work?", "Please Confirm Action", MessageBoxButton.YesNoCancel);
                if (r != MessageBoxResult.Yes)
                {
                    OverWrite = false;
                }
            }
            return OverWrite;
        }

        private void Windows_Closing(object sender, System.ComponentModel.CancelEventArgs e)
        {
            e.Cancel = this.ConfirmAbandon();
        }

        private bool ConfirmAbandon()
        {
            bool Abandon = false;
            if (m_Document == null)
            {
                Abandon = true;
            }
            else if (m_Document.Dirty == false)
            {
                Abandon = true;
            }
            else if (m_Document.Dirty == true )
            {
                MessageBoxResult r = MessageBox.Show("You have work in progress\nDo you want exit without saving?", "Please Confirm Action", MessageBoxButton.YesNoCancel);
                if (r==MessageBoxResult.Yes)
                {
                    Abandon = true;
                    m_Document = null;
                }
            }
            return Abandon;
        }


        private void saveFile_Click(object sender, RoutedEventArgs e)
        {
            if (m_Document.Path == null)
            {
                SaveFileDialog dlg = new SaveFileDialog();
                if (true == dlg.ShowDialog())
                {
                    m_Document.Path = dlg.FileName;
                }
            }
            if (m_Document.Path != null)
            {
                if (!m_Document.Save())
                {
                    MessageBox.Show("couldn't save " + m_Document.Path.ToString());
                }
                this.saveFile.IsEnabled = false;
            }
        }

        private void openFile_Click(object sender, RoutedEventArgs e)
        {
            if (ConfirmOverWrite())
            {
                OpenFileDialog dlg = new OpenFileDialog();
                if (true == dlg.ShowDialog())
                {
                    m_Document = new Document();
                    if (m_Document.Open(dlg.FileName))
                    {
                        textEditBox.IsEnabled = true;
                        textEditBox.Text = m_Document.Text;
                        this.saveFile.IsEnabled = false;
                    }
                }
            }
        }

        private void menu_exit_Click(object sender, RoutedEventArgs e)
        {
            if (ConfirmAbandon()) 
            {
                Application.Current.Shutdown();
            }
        }

        private void newFile_Click(object sender, RoutedEventArgs e)
        {
            if (ConfirmOverWrite())
            {
                m_Document = new Document();
                textEditBox.Text = "";
                textEditBox.IsEnabled = true;
            }
        }

        private void textEditBox_TextChanged(object sender, TextChangedEventArgs e)
        {
            m_Document.Text = textEditBox.Text;
            this.saveFile.IsEnabled = true;
        }

        private void textEditBox_TextInput(object sender, TextCompositionEventArgs e)
        {
            m_Document.Text = textEditBox.Text;
            this.saveFile.IsEnabled = true;
        }

        Document m_Document;

    }
}
