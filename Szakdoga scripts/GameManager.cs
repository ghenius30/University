using System;
using System.Collections.Generic;
using UnityEngine;
using System.Linq;

public class GameManager : MonoBehaviour
{
    public GameObject[] playersGOArr;
    public GameObject blue;
    public GameObject orange;
    public GameObject green;
    public GameObject yellow;

    public GameObject[] goArr;

    Player[] playersArr;
    Player bluePlayer;
    Player orangePlayer;
    Player greenPlayer;
    Player yellowPlayer;

    List<string> colors = new List<string>();
    string[] randomColors = new string[PlayerNumDropdown.playerNumber];

    string[] randomNames = new string[PlayerNumDropdown.playerNumber];

    int activePlayer;
    int randX;
    int randZ;

    public static float playerXPos;
    public static float playerYPos = 2.55f;
    public static float playerZPos;
    public static int maxMove = 3;

    System.Random random = new System.Random();

    // Start is called before the first frame update
    void Start()
    {
        colors.Add("orange");
        colors.Add("blue");
        colors.Add("yellow");
        colors.Add("green");

        selectRandColors();
        selectRandNames();
        activePlayer = random.Next(0, PlayerNumDropdown.playerNumber);
        playersGOArr = new GameObject[PlayerNumDropdown.playerNumber];
        playersArr = new Player[PlayerNumDropdown.playerNumber];
        goArr = GameObject.FindObjectsOfType<GameObject>();

        createPlayers();

        print(playersArr[activePlayer].PlayerName + " játékos (" + playersGOArr[activePlayer].name + ") lép");
    }

    // Update is called once per frame
    void Update()
    {
        movePlayer();
    }

    private void movePlayer()
    {
        if (maxMove != 0)
        {
            if (ObjectClicker.selectedTileObj != null)
            {
                playerXPos = ObjectClicker.selectedTileObj.transform.position.x;
                playerZPos = ObjectClicker.selectedTileObj.transform.position.z;

                playersArr[activePlayer].PlayerX = int.Parse(ObjectClicker.selectedTile[1]);
                playersArr[activePlayer].PlayerZ = int.Parse(ObjectClicker.selectedTile[2]);

                //print(playersArr[activePlayer].PlayerX +", " + playersArr[activePlayer].PlayerZ);

                playersGOArr[activePlayer].transform.position = new Vector3(playerXPos, playerYPos, playerZPos);

                if (ObjectClicker.selectedTileObj != ObjectClicker.prevTileObj)
                {
                    maxMove--;
                }

                ObjectClicker.prevTileObj = ObjectClicker.selectedTileObj;
                ObjectClicker.selectedTileObj = null;
            }
            else
            {
                resetTileTags();

                int X = playersArr[activePlayer].PlayerX;
                int Z = playersArr[activePlayer].PlayerZ;

                string actualHexGroup = MapMaterials.STRMAP_1[X, Z];

                for (int i = 0; i < Map.mapHeight; i++)
                {
                    for (int j = 0; j < Map.mapHeight; j++)
                    {
                        if (MapMaterials.STRMAP_1[i, j] == actualHexGroup)
                        {
                            foreach (GameObject go in goArr)
                            {
                                if (go.name == "Hex_"+ i + "_" + j)
                                {
                                    go.tag = "ClickableTile";
                                }
                            }
                        }
                    }
                }
                
                if (GameObject.Find("Hex_" + (X + 1) + "_" + Z))
                {
                    GameObject.Find("Hex_" + (X + 1) + "_" + Z).tag = "ClickableTile";
                }

                if (GameObject.Find("Hex_" + X + "_" + (Z + 1)))
                {
                    GameObject.Find("Hex_" + X + "_" + (Z + 1)).tag = "ClickableTile";
                }

                if (GameObject.Find("Hex_" + (X - 1) + "_" + Z))
                {
                    GameObject.Find("Hex_" + (X - 1) + "_" + Z).tag = "ClickableTile";
                }

                if (GameObject.Find("Hex_" + X + "_" + (Z - 1)))
                {
                    GameObject.Find("Hex_" + X + "_" + (Z - 1)).tag = "ClickableTile";
                }
                
                if (GameObject.Find("Hex_" + (X - 1) + "_" + (Z + 1)))
                {
                    GameObject.Find("Hex_" + (X - 1) + "_" + (Z + 1)).tag = "ClickableTile";
                }

                if (GameObject.Find("Hex_" + (X + 1) + "_" + (Z - 1)))
                {
                    GameObject.Find("Hex_" + (X + 1) + "_" + (Z - 1)).tag = "ClickableTile";
                }
            }
        }
        else
        {
            activePlayer = (activePlayer + 1) % PlayerNumDropdown.playerNumber;
            print(playersArr[activePlayer].PlayerName+ " játékos ("+playersGOArr[activePlayer].name + ") lép");
            maxMove = 3;
            //print(ObjectClicker.prevTileObj.name);

        }
    }

    private void randomStartPos()
    {
        randX = random.Next(0, 12);
        randZ = random.Next(0, 12);
        
        if (GameObject.Find("Hex_" + randX + "_" + randZ))
        {
            playerXPos = GameObject.Find("Hex_" + randX + "_" + randZ).transform.position.x;
            playerZPos = GameObject.Find("Hex_" + randX + "_" + randZ).transform.position.z;
            //print(randX + ", " + randZ);
        }
        else
        {
            randomStartPos();
        }
    }

    private void resetTileTags()
    {
        foreach (GameObject go in goArr)
        {
            if (go.name.Contains("Hex_"))
            {
                go.tag = "Tile";
            }
        }
    }

    public void selectRandColors()
    {
        int maxNum = 4;

        for (int i = 0; i < PlayerNumDropdown.playerNumber; i++)
        {
            int rand = random.Next(0, maxNum);
            var pickedColor = colors.ElementAt(rand);
            colors.RemoveRange(rand, 1);
            randomColors[i] = pickedColor.ToString();
            maxNum--;
        }
    }

    public void selectRandNames()
    {
        int n = PlayerNumDropdown.playerNumber;

        randomNames[0] = PlayerNameInputs.player1_name;
        randomNames[1] = PlayerNameInputs.player2_name;

        if (n == 3 || n == 4)
        {
            randomNames[2] = PlayerNameInputs.player3_name;
        }

        if (PlayerNumDropdown.playerNumber == 4)
        {
            randomNames[3] = PlayerNameInputs.player4_name;
        }

        
        while (n > 1)
        {
            int k = random.Next(n--);
            string temp = randomNames[n];
            randomNames[n] = randomNames[k];
            randomNames[k] = temp;
        }
    }

    public void createPlayers()
    {
        if (randomColors.Contains("blue"))
        {
            randomStartPos();
            bluePlayer = new Player(randX, randZ, blue);

            GameObject bluePlayerGO = (GameObject)Instantiate(blue, new Vector3(playerXPos, playerYPos, playerZPos), Quaternion.identity);
            bluePlayerGO.transform.SetParent(this.transform);
            bluePlayerGO.transform.Rotate(-90.0f, 180.0f, 0.0f, Space.Self);
            bluePlayerGO.transform.localScale = new Vector3(0.1f, 0.1f, 0.1f);
            bluePlayerGO.name = "BluePlayer";

            bluePlayer.PlayerName = randomNames[Array.IndexOf(randomColors, "blue")];
            playersArr[Array.IndexOf(randomColors, "blue")] = bluePlayer;
            playersGOArr[Array.IndexOf(randomColors, "blue")] = bluePlayerGO;
        }

        if (randomColors.Contains("orange"))
        {
            randomStartPos();
            orangePlayer = new Player(randX, randZ, orange);

            GameObject orangePlayerGO = (GameObject)Instantiate(orange, new Vector3(playerXPos, playerYPos, playerZPos), Quaternion.identity);
            orangePlayerGO.transform.SetParent(this.transform);
            orangePlayerGO.transform.Rotate(-90.0f, 180.0f, 0.0f, Space.Self);
            orangePlayerGO.transform.localScale = new Vector3(0.1f, 0.1f, 0.1f);
            orangePlayerGO.name = "OrangePlayer";

            orangePlayer.PlayerName = randomNames[Array.IndexOf(randomColors, "orange")];
            playersArr[Array.IndexOf(randomColors, "orange")] = orangePlayer;
            playersGOArr[Array.IndexOf(randomColors, "orange")] = orangePlayerGO;
        }

        if (randomColors.Contains("green"))
        {
            randomStartPos();
            greenPlayer = new Player(randX, randZ, green);

            GameObject greenPlayerGO = (GameObject)Instantiate(green, new Vector3(playerXPos, playerYPos, playerZPos), Quaternion.identity);
            greenPlayerGO.transform.SetParent(this.transform);
            greenPlayerGO.transform.Rotate(-90.0f, 180.0f, 0.0f, Space.Self);
            greenPlayerGO.transform.localScale = new Vector3(0.1f, 0.1f, 0.1f);
            greenPlayerGO.name = "GreenPlayer";

            greenPlayer.PlayerName = randomNames[Array.IndexOf(randomColors, "green")];
            playersArr[Array.IndexOf(randomColors, "green")] = greenPlayer;
            playersGOArr[Array.IndexOf(randomColors, "green")] = greenPlayerGO;
        }

        if (randomColors.Contains("yellow"))
        {
            randomStartPos();
            yellowPlayer = new Player(randX, randZ, yellow);

            GameObject yellowPlayerGO = (GameObject)Instantiate(yellow, new Vector3(playerXPos, playerYPos, playerZPos), Quaternion.identity);
            yellowPlayerGO.transform.SetParent(this.transform);
            yellowPlayerGO.transform.Rotate(-90.0f, 180.0f, 0.0f, Space.Self);
            yellowPlayerGO.transform.localScale = new Vector3(0.1f, 0.1f, 0.1f);
            yellowPlayerGO.name = "YellowPlayer";

            yellowPlayer.PlayerName = randomNames[Array.IndexOf(randomColors, "yellow")];
            playersArr[Array.IndexOf(randomColors, "yellow")] = yellowPlayer;
            playersGOArr[Array.IndexOf(randomColors, "yellow")] = yellowPlayerGO;
        }
    }
}