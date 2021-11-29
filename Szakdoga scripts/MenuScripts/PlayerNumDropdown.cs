using System;
using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;

public class PlayerNumDropdown : MonoBehaviour
{
    public Dropdown playerNumDropdown;

    public GameObject input3;
    public GameObject input4;

    public static int playerNumber;

    // Start is called before the first frame update
    void Start()
    {
        SetPlayerNumber(playerNumDropdown);

        playerNumDropdown.onValueChanged.AddListener(delegate 
        {
            SetPlayerNumber(playerNumDropdown);
        });
    }

    private void SetPlayerNumber(Dropdown selected)
    {
        int selectedItem = selected.value;

        switch (selectedItem)
        {
            case 0:
                playerNumber = 2;
                input3.SetActive(false);
                input4.SetActive(false);
                break;

            case 1:
                playerNumber = 3;
                input3.SetActive(true);
                input4.SetActive(false);
                break;

            case 2:
                playerNumber = 4;
                input3.SetActive(true);
                input4.SetActive(true);
                break;
        }
    }
}
