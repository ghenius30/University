using UnityEngine;

public class RotateTurbine : MonoBehaviour
{
    public GameObject turbine;

    // Start is called before the first frame update
    void Start()
    {
        
    }

    // Update is called once per frame
    void Update()
    {
        turbine.transform.Rotate(new Vector3(0, 0, 1.5f));
    }
}
