using UnityEngine;

public class ObjectClicker : MonoBehaviour
{
    public static string[] selectedTile = new string[3];
    public static GameObject selectedTileObj;
    public static GameObject prevTileObj;
    // Update is called once per frame
    void Update()
    {
        if (Input.GetMouseButtonDown(0))
        {
            RaycastHit hit;
            Ray ray = Camera.main.ScreenPointToRay(Input.mousePosition);

            if (Physics.Raycast(ray, out hit, 100.0f))
            {
                if (hit.transform != null)
                {
                    if (hit.transform.gameObject.tag == "ClickableTile")
                    {
                        selectedTile = hit.collider.gameObject.name.Split('_');
                        selectedTileObj = hit.collider.gameObject;
                        
                        //prevTileObj = hit.collider.gameObject;
                        //print(selectedTile[1] + ", " + selectedTile[2]);
                        //PrintName(hit.transform.gameObject.);
                    }
                }
            }
        }
}

   /* private void PrintName(GameObject GO)
    {
        
                    {
        if (GO.tag == "Tile")
        {
            print(GO.name);
            param = GO.name.Split('_');
            
        }
        
    }*/
}
