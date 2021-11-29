using System;
using System.Collections.Generic;
using System.Linq;
using UnityEngine;

public class MapMaterials : MonoBehaviour
{
    public static int VULCAN = 1;
    public static int DESERT = 2;
    public static int CRATER = 3;
    public static int SOLARPANEL = 4;
    public static int LAVA = 5;
    public static int ICE = 6;

    public static string VULCAN_str = "v";
    public static string DESERT_str = "d";
    public static string CRATER_str = "c";
    public static string SOLARPANEL_str = "s";
    public static string LAVA_str = "l";
    public static string ICE_str = "i";

    public static string LARGEST_VULCAN;
    public static string LARGEST_DESERT;
    public static string LARGEST_CRATER;
    public static string LARGEST_SOLARPANEL;
    public static string LARGEST_LAVA;
    public static string LARGEST_ICE;

    public static string[,] STRMAP_1 = new string[11,11];

    public int[,] adjacent = { { 1, 0 }, { 0, 1 }, { -1, 0 }, { 0, -1 }, { -1, 1 },  { 1, -1 } };
    public string[] typeNames = {"", VULCAN_str, DESERT_str, CRATER_str, SOLARPANEL_str, LAVA_str, ICE_str};

    public static int[,] MAP_1 = 
    {
        {0,0,0,0,0,6,6,1,1,1,1},
        {0,0,0,0,2,6,4,4,3,3,1},
        {0,0,0,2,2,6,4,4,6,3,3},
        {0,0,2,2,2,3,1,6,6,6,6},
        {0,2,4,4,3,5,1,2,2,2,6},
        {1,1,4,3,5,5,2,2,2,5,6},
        {1,3,6,6,5,5,4,4,5,5,0},
        {3,3,3,6,2,3,3,3,5,0,0},
        {3,6,6,4,2,3,3,3,0,0,0},
        {3,6,4,4,2,1,1,0,0,0,0},
        {3,4,4,2,1,1,0,0,0,0,0}
    };

    public static int[,] MAP_2 =
    {
        {0,0,0,0,0,1,1,3,2,2,2},
        {0,0,0,0,5,5,1,3,2,2,2},
        {0,0,0,6,5,1,3,3,2,5,5},
        {0,0,6,5,5,1,1,3,5,5,1},
        {0,4,6,6,5,4,1,6,1,1,4},
        {4,4,3,3,4,4,6,6,1,4,4},
        {4,3,3,4,4,6,6,6,2,2,0},
        {3,3,2,4,4,6,2,2,2,0,0},
        {3,6,2,1,1,1,2,5,0,0,0},
        {6,6,2,1,1,5,5,0,0,0,0},
        {6,6,2,3,3,3,0,0,0,0,0}
    };

    public static int[,] MAP_3 =
    {
        {0,0,0,0,0,1,1,6,6,4,4},
        {0,0,0,0,4,4,1,6,4,4,4},
        {0,0,0,4,4,2,1,1,1,4,3},
        {0,0,6,2,2,3,5,1,3,3,1},
        {0,6,6,6,3,3,5,1,3,3,1},
        {5,6,6,6,3,5,5,5,2,2,1},
        {5,5,2,6,5,1,1,6,2,1,0},
        {5,1,2,2,1,1,6,2,2,0,0},
        {1,1,2,2,1,6,6,2,0,0,0},
        {3,3,3,3,4,4,2,0,0,0,0},
        {3,3,3,3,4,2,0,0,0,0,0}
    };

    public static int[,] MAP_4 =
    {
        {0,0,0,0,0,3,3,3,1,1,4},
        {0,0,0,0,2,3,3,1,2,4,4},
        {0,0,0,2,3,3,3,2,6,4,5},
        {0,0,6,2,6,6,2,2,6,5,5},
        {0,6,6,6,4,6,2,6,6,1,1},
        {1,1,5,4,4,4,2,6,1,1,1},
        {1,5,5,1,4,3,5,5,1,1,0},
        {1,5,1,1,3,3,5,3,3,0,0},
        {6,6,1,1,2,5,3,3,0,0,0},
        {6,6,2,2,2,5,4,0,0,0,0},
        {2,2,2,2,4,4,0,0,0,0,0}
    };



    // Start is called before the first frame update
    void Start()
    {
        switch (MapToggleGroup.mapName)
        {
            case "MAP_1":
                generateHexGroups(MAP_1, STRMAP_1);
                break;

            case "MAP_2":
                generateHexGroups(MAP_2, STRMAP_1);
                break;

            case "MAP_3":
                generateHexGroups(MAP_3, STRMAP_1);
                break;

            case "MAP_4":
                generateHexGroups(MAP_4, STRMAP_1);
                break;
        }
        findLargest(STRMAP_1);
    }

    // Update is called once per frame
    void Update()
    {
        
    }

    public void generateHexGroups(int[,] array, string[,] strArray)
    {
        int[] typeCounters = new int[typeNames.Length];

        Queue<Vector2Int> examine = new Queue<Vector2Int>();

        for (int i = 0; i < typeCounters.Length; i++)
        {
            typeCounters[i] = 0;
        }

        for (int i = 0; i < Map.mapHeight; i++)
        {
            for (int j = 0; j < Map.mapHeight; j++)
            {
                if (array[i, j] == 0) {
                    strArray[i, j] = "";
                } 
                else
                {
                    strArray[i, j] = "0";
                }
            }
        } 

        for (int i = 0; i < Map.mapHeight; i++)
        {
            for (int j = 0; j < Map.mapHeight; j++)
            {
                if (strArray[i, j] == "0")
                {
                    int x = i;
                    int y = j;

                    examine.Enqueue(new Vector2Int(x, y));

                    typeCounters[array[x, y]]++;
                    String strTag = typeNames[array[x, y]] + typeCounters[array[x, y]];

                    while (true)
                    {
                        if (examine.Count <= 0)
                        {
                            break;
                        }

                        Vector2Int actual = examine.Dequeue();

                        strArray[actual.x, actual.y] = strTag;
                        //print("x: " + actual.x + ", y: " + actual.y + ", cimke: " + strArray[actual.x, actual.y]);

                        if (array[actual.x, actual.y] == array[x, y])
                        {
                            for (int k = 0; k < adjacent.Length/2; k++)
                            {
                                int cx = actual.x + adjacent[k, 0];
                                int cy = actual.y + adjacent[k, 1];

                                if (cx < 0 || cx > 10 || cy < 0 || cy > 10) 
                                {
                                    continue;
                                } 
                                else if (strArray[cx, cy] == "0")
                                {
                                    if (array[cx, cy] == array[x, y])
                                    {
                                        examine.Enqueue(new Vector2Int(cx, cy));
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public void findLargest(string[,] strArray)
    {
        Queue<string> types = new Queue<string>();
        string[] arr;

        foreach (var type in strArray)
        {
            if (!types.Contains(type))
            {
                if (type != "")
                {
                    types.Enqueue(type);
                }
            }
        }
        arr = types.ToArray();
        types.Clear();

        int[] countTypes = new int[arr.Length];

        for (int i = 0; i < arr.Length; i++)
        {
            countTypes[i] = 0;
        }

        for (int i = 0; i < arr.Length; i++)
        {
            for (int j = 0; j < strArray.GetLength(0); j++)
            {
                for (int k = 0; k < strArray.GetLength(1); k++)
                {
                    if (arr[i] == strArray[j, k])
                    {
                        countTypes[i]++;
                    }
                }
            }
        }

        LARGEST_VULCAN = getMax(VULCAN_str);
        LARGEST_DESERT = getMax(DESERT_str);
        LARGEST_CRATER = getMax(CRATER_str);
        LARGEST_SOLARPANEL = getMax(SOLARPANEL_str);
        LARGEST_LAVA = getMax(LAVA_str);
        LARGEST_ICE = getMax(ICE_str);

        string getMax(string strType)
        {
            string[] typeCounter = new string[100];
            int[] numCounter = new int[100];

            for (int i = 0; i < arr.Length; i++)
            {
                if (arr[i].StartsWith(strType))
                {
                    typeCounter[i] = arr[i];
                    //print(typeCounter[i]);
                    numCounter[i] = countTypes[i];
                    //print(numCounter[i]);
                }
            }
            
            int index = numCounter.ToList().IndexOf(numCounter.Max());

            return typeCounter[index];
        }


        /*for (int i = 0; i < arr.Length; i++) {
            {
                print(arr[i] + ": " + countTypes[i]);
            }
        }
        for (int i = 0; i < strArray.GetLength(0); i++)
        {
            for (int j = 0; j < strArray.GetLength(1); j++)
            {
                print(strArray[i, j]);
            }
        }*/
    }

}