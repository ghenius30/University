using System.Collections;
using UnityEngine;

namespace Assets.Scripts.MenuScripts
{
    public abstract class Buildings
    {
        protected Buildings(int x, int z, GameObject go)
        {
        }

        public class Base : Buildings
        {

            int xPos;
            int zPos;
            GameObject GO;

            public Base(int x, int z, GameObject go)
            {
                this.xPos = x;
                this.zPos = z;
                this.GO = go;
            }
           

        }

        public class Antenna
        {

        }

        public class Turbine
        {

        }


        // Use this for initialization
        void Start()
        {

        }

        // Update is called once per frame
        void Update()
        {

        }
    }
}