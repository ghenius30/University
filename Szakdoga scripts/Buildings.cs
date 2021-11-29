using System.Collections;
using UnityEngine;

namespace Assets.Scripts.MenuScripts
{
    public abstract class Buildings
    {

        public int xPos;
        public int zPos;
        public GameObject GO;

        protected Buildings(int x, int z, GameObject go)
        {
        }

        public class Basis : Buildings
        {
            public Basis(int x, int z, GameObject go) : base(x, z, go)
            {
                xPos = x;
                zPos = z;
                GO = go;
            }
        }

        public class Antenna : Buildings
        {
            public Antenna(int x, int z, GameObject go) : base(x, z, go)
            {
                xPos = x;
                zPos = z;
                GO = go;
            }
        }

        public class Turbine : Buildings
        {
            public Turbine(int x, int z, GameObject go) : base(x, z, go)
            {
                xPos = x;
                zPos = z;
                GO = go;
            }
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