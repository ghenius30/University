using System.Collections;
using System.Collections.Generic;
using System.Linq;
using UnityEngine;
using UnityEngine.UI;

public class MapToggleGroup : MonoBehaviour
{
    ToggleGroup toggleGroup;

    public static string mapName;

    public Toggle currentSelection
    {
        get { return toggleGroup.ActiveToggles().FirstOrDefault(); }
    }

    public void SetMap()
    {
        toggleGroup = GetComponent<ToggleGroup>();
        mapName = currentSelection.name;
    }

    public void Start()
    {
        SetMap();
    }

}
