using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace WpfApplication1
{
    class Document : IDisposable
    {
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
                _dirty = false;
                System.IO.File.WriteAllText(Path, Text);
            }
            return RetVal;
        }

        public void Dispose()
        {

        }
        string _path;

        public string Path
        {
            get { return _path; }
            set
            {
                _dirty = true;
                _path = value;
            }
        }

        string _text;

        public string Text
        {
            get { return _text; }
            set
            {
                _dirty = true;
                _text = value; 
            }
        }

        bool _dirty;

        public bool Dirty
        {
            get { return _dirty; }
            set { _dirty = value; }
        }
    }
}
