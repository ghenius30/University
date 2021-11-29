using UnityEngine;

public class Player
{
    public string playerName;
    public int xPos;
    public int zPos;
    public GameObject GO;

    public Player(int x, int z, GameObject go)
    {
        this.xPos = x;
        this.zPos = z;
        this.GO = go;
    }

    public string PlayerName
    {
        get { return playerName; }
        set { playerName = value; }
    }

    public int PlayerX
    {
        get { return xPos; }
        set { xPos = value; }
    }

    public int PlayerZ
    {
        get { return zPos; }
        set { zPos = value; }
    }

    public override string ToString()
    {
        return xPos.ToString() + ", " + zPos.ToString();
    }

    // Start is called before the first frame update
    void Start()
    {
        
    }

    // Update is called once per frame
    void Update()
    {
        
    }
}
