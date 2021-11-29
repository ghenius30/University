using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
using TMPro;
using System.Text.RegularExpressions;

public class PlayerNameInputs : MonoBehaviour
{
    public TMP_InputField player1_input;
    public TMP_InputField player2_input;
    public TMP_InputField player3_input;
    public TMP_InputField player4_input;

    public static string player1_name;
    public static string player2_name;
    public static string player3_name;
    public static string player4_name;

    // Start is called before the first frame update
    void Start()
    {
        GetNames();
    }

    public void GetNames()
    {
        player1_name = player1_input.text;
        player1_input.onValueChanged.AddListener(delegate
        {
            player1_name = player1_input.text;

            if (player1_name == "" || Regex.IsMatch(player1_name, @"\s+") || player1_name.Length > 15)
            {
                player1_input.text = "player1";
            }
        });
        

        player2_name = player2_input.text;
        player2_input.onValueChanged.AddListener(delegate
        {
            player2_name = player2_input.text;

            if (player2_name == "" || Regex.IsMatch(player2_name, @"\s+") || player2_name.Length > 15)
            {
                player2_input.text = "player2";
            }
        });


        if (PlayerNumDropdown.playerNumber == 3 || PlayerNumDropdown.playerNumber == 4)
        {
            player3_name = player3_input.text;
            player3_input.onValueChanged.AddListener(delegate
            {
                player3_name = player3_input.text;

                if (player3_name == "" || Regex.IsMatch(player3_name, @"\s+") || player3_name.Length > 15)
                {
                    player3_input.text = "player3";
                }
            });
        }

        if (PlayerNumDropdown.playerNumber == 4)
        {
            player4_name = player4_input.text;
            player4_input.onValueChanged.AddListener(delegate
            {
                player4_name = player4_input.text;

                if (player4_name == "" || Regex.IsMatch(player4_name, @"\s+") || player4_name.Length > 15)
                {
                    player4_input.text = "player4";
                }
            });
        }
    }
}
