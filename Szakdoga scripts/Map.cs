using UnityEngine;

public class Map : MonoBehaviour
{
    public GameObject hexPrefab;

    Renderer rend;

    public Material vulcanMat;
    public Material desertMat;
    public Material craterMat;
    public Material solarpanelMat;
    public Material lavaMat;
    public Material iceMat;
    
    public static int mapHeight = 11;
    int currRow;
    int currCol = 0;
    int maxCol = 6;
    int rowOffset = 0;
    int colOffset = 0;

    public static float xOffset = 0.89f;
    public static float zOffset = 1.56f;

    float xPos = 0;
    float yPos = 2.5f;
    float zPos = 0;


    // Start is called before the first frame update
    void Start()
    {

        for (currRow = 0; currRow < mapHeight; currRow++)
        {
            if (currRow < 6)
            {
                if (currRow >= 1)
                {
                    maxCol++;
                }

                xPos = currRow * -xOffset;
                zPos = currRow * zOffset;

            }
            else
            {
                if (currRow >= 6)
                {
                    maxCol--;
                }
                rowOffset += 2;
                xPos = (currRow * -xOffset) + (xOffset * rowOffset);
                zPos = currRow * zOffset;

            }

            for (currCol = 0; currCol < maxCol; currCol++)
            {

                GameObject hex_GO = (GameObject)Instantiate(hexPrefab, new Vector3(xPos, yPos, zPos), Quaternion.identity);
                xPos += 0.9f + xOffset;

                hex_GO.transform.SetParent(this.transform);
                hex_GO.transform.Rotate(90.0f, 0.0f, 0.0f, Space.Self);
                hex_GO.tag = "Tile";

                countOffset(currRow);
                
                hex_GO.name = "Hex_" + currRow + "_" + (currCol+colOffset);

                rend = hex_GO.GetComponent<Renderer>();
                rend.enabled = true;

                int actualMap = MapMaterials.MAP_1[currRow, currCol + colOffset]; ;

                switch (MapToggleGroup.mapName)
                {
                    case "MAP_1":
                        actualMap = MapMaterials.MAP_1[currRow, currCol + colOffset];
                        break;

                    case "MAP_2":
                        actualMap = MapMaterials.MAP_2[currRow, currCol + colOffset];
                        break;

                    case "MAP_3":
                        actualMap = MapMaterials.MAP_3[currRow, currCol + colOffset];
                        break;

                    case "MAP_4":
                        actualMap = MapMaterials.MAP_4[currRow, currCol + colOffset];
                        break;
                }

                if (actualMap == MapMaterials.VULCAN) {
                    rend.material = vulcanMat;
                                        
                } else if (actualMap == MapMaterials.DESERT){
                    rend.material = desertMat;
                    
                } else if (actualMap == MapMaterials.CRATER){
                    rend.material = craterMat;
                    
                } else if (actualMap == MapMaterials.SOLARPANEL){
                    rend.material = solarpanelMat;
                    
                } else if (actualMap == MapMaterials.LAVA){
                    rend.material = lavaMat;
                    
                } else if (actualMap == MapMaterials.ICE){
                    rend.material = iceMat;
                }
            }
        }
    }


    void countOffset(int row)
    {
        switch (row)
        {
            case 0:
                colOffset = 5; break;
            case 1:
                colOffset = 4; break;
            case 2:
                colOffset = 3; break;
            case 3:
                colOffset = 2; break;
            case 4:
                colOffset = 1; break;
            default:
                colOffset = 0; break;
        }
    }

    // Update is called once per frame
    void Update()
    {
        
    }
}