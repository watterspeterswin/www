using System;
using System.Text;
using System.IO;

namespace SimpleEditNS
{
    class Document 
    {
        string _path;
        string _text;
        bool _dirty;

        public Document()
        {
            _dirty = false;
        }

        public bool Open(string p)
        {
            bool RetVal = true;
            Path = p;
            this.Text = System.IO.File.ReadAllText(this.Path);     
            this.Dirty = false;
            return RetVal;
        }

        public bool Save()
        {
            bool RetVal = (Path != null);

            if (RetVal)
            {
                System.IO.File.WriteAllText(Path, Text);
                _dirty = false;
            }
            return RetVal;
        }


        public string Path
        {
            get { return _path; }
            set
            {
                _path = value;
            }
        }

        public string Text
        {
            get { return _text; }
            set
            {
                _text = value; 
            }
        }

        public bool Dirty
        {
            get { return _dirty; }
            set { _dirty = value; }
        }
    }
}
