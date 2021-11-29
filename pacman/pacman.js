$(document).ready(function () {
    $('<div class="start"></div>').appendTo('body');
    $('<div id="startText"></div>').appendTo('.start');
    var start = $('#startText');
    start.text('START');
    start.click(function () {
        $('div').remove();
        animate();
    });
});

    var is_animate = true;
    var score = 0;
    var eatable = false;
    var lunchTime;
    var eatenGhost = 0;
    var lives = 3;
    var pacmanDir = "right";
    var coins = 152;
    var mg;
    var sirensong;

    WALL = 0;
    COIN = 1;
    GROUND = 2;
    PILL = 4;
    PACMAN = 5;
    BLINKY = 6;//piros
    INKY = 7;//kék
    PINKY = 8;//pink
    CLYDE = 9;//narancs

    var prevFieldInky = GROUND;
    var prevFieldBlinky = GROUND;
    var prevFieldPinky = GROUND;
    var prevFieldClyde = GROUND;

    var pacman = {
        x: 9,
        y: 16
    };

    var blinky = {
        x: 9,
        y: 9
    };
    var inky = {
        x: 8,
        y: 10
    };
    var pinky = {
        x: 9,
        y: 10
    };
    var clyde = {
        x: 10,
        y: 10
    };


    var MAP = [
        [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        [0, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 0],
        [0, 4, 0, 0, 1, 0, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0, 0, 4, 0],
        [0, 1, 0, 0, 1, 0, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0, 0, 1, 0],
        [0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0],
        [0, 1, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 1, 0],
        [0, 1, 1, 1, 1, 0, 1, 1, 1, 0, 1, 1, 1, 0, 1, 1, 1, 1, 0],
        [0, 0, 0, 0, 1, 0, 0, 0, 2, 0, 2, 0, 0, 0, 1, 0, 0, 0, 0],
        [2, 2, 2, 0, 1, 0, 2, 2, 2, 2, 2, 2, 2, 0, 1, 0, 2, 2, 2],
        [0, 0, 0, 0, 1, 0, 2, 0, 0, 6, 0, 0, 2, 0, 1, 0, 0, 0, 0],
        [2, 2, 2, 2, 1, 2, 2, 0, 7, 8, 9, 0, 2, 2, 1, 2, 2, 2, 2],
        [0, 0, 0, 0, 1, 0, 2, 0, 0, 0, 0, 0, 2, 0, 1, 0, 0, 0, 0],
        [2, 2, 2, 0, 1, 0, 2, 2, 2, 2, 2, 2, 2, 0, 1, 0, 2, 2, 2],
        [0, 0, 0, 0, 1, 0, 2, 0, 0, 0, 0, 0, 2, 0, 1, 0, 0, 0, 0],
        [0, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 0],
        [0, 1, 0, 0, 1, 0, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0, 0, 1, 0],
        [0, 4, 1, 0, 1, 1, 1, 1, 1, 5, 1, 1, 1, 1, 1, 0, 1, 4, 0],
        [0, 0, 1, 0, 1, 0, 1, 0, 0, 0, 0, 0, 1, 0, 1, 0, 1, 0, 0],
        [0, 1, 1, 1, 1, 0, 1, 1, 1, 0, 1, 1, 1, 0, 1, 1, 1, 1, 0],
        [0, 1, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 1, 0],
        [0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0],
        [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
    ];

    function drawMap() {
        $('<div class="game"></div>').appendTo('body');
        $('<div class="footbar"></div>').appendTo('body');
        countLives();
        countScore();
        for (var y = 0; y < MAP.length; y++) {
            for (var x = 0; x < MAP[y].length; x++) {
                if (MAP[y][x] === WALL) {
                    $('<div class="wall"></div>').appendTo('.game');
                } else if (MAP[y][x] === COIN) {
                    $('<div class="coin"></div>').appendTo('.game');
                } else if (MAP[y][x] === GROUND) {
                    $('<div class="ground"></div>').appendTo('.game');
                } else if (MAP[y][x] === PILL) {
                    $('<div class="pill"></div>').appendTo('.game');
                } else if (MAP[y][x] === PACMAN) {
                    $('<div class="pacmandiv""><div class="pacman"></div></div>').appendTo('.game');
                } else if (MAP[y][x] === BLINKY) {
                    $('<div class="ground"><div id="blinky" class="ghost"><span class="eyes"></span><div class="skirtdiv"><span class="skirt"><span></span></span></div></div></div>').appendTo('.game');
                } else if (MAP[y][x] === INKY) {
                    $('<div class="ground"><div id="inky" class="ghost"><span class="eyes"></span><div class="skirtdiv"><span class="skirt"><span></span></span></div></div></div>').appendTo('.game');
                } else if (MAP[y][x] === PINKY) {
                    $('<div class="ground"><div id="pinky" class="ghost"><span class="eyes"></span><div class="skirtdiv"><span class="skirt"><span></span></span></div></div></div>').appendTo('.game');
                } else if (MAP[y][x] === CLYDE) {
                    $('<div class="ground"><div id="clyde" class="ghost"><span class="eyes"></span><div class="skirtdiv"><span class="skirt"><span></span></span></div></div></div>').appendTo('.game');
                }

            }
            $('<br>').appendTo('.game');
        }
        if (eatable) {
            eatGhost();
        }
    }

    function countScore(){
        $('<span class="score"></span>').appendTo('.footbar');
        $('.score').html('SCORE: '+score);
    }
    function countLives() {
        $('<span class="lives"></span>').appendTo('.footbar');
        $('.lives').text('LIVES: ');
        for (var i = 0; i < lives; i++) {
            var pacmanImg = $('<img src="css/pacman.png" alt="pacman lives"/>');
            pacmanImg.css({
                width: '20px',
                height: '20px',
                display: 'inline-block',
                marginRight: '5px'
            });
            pacmanImg.appendTo('.lives');
        }
    }

    function movePacman() {
        $(window).on("keydown", function (e) {
            if (is_animate) {
                if (e.key === "ArrowLeft") {
                    if (MAP[pacman.y][pacman.x - 1] !== WALL) {
                        $('div').remove();
                        MAP[pacman.y][pacman.x] = GROUND;
                        pacman.x -= 1;
                        pacmanAction();

                        pacmanDir = "left";
                        setPacmanDirection(pacmanDir);
                    }
                } else if (e.key === "ArrowUp") {
                    if (MAP[pacman.y - 1][pacman.x] !== WALL) {
                        $('div').remove();
                        MAP[pacman.y][pacman.x] = GROUND;
                        pacman.y -= 1;
                        pacmanAction();

                        pacmanDir = "up";
                        setPacmanDirection(pacmanDir);
                    }
                } else if (e.key === "ArrowRight") {
                    if (MAP[pacman.y][pacman.x + 1] !== WALL) {
                        $('div').remove();
                        MAP[pacman.y][pacman.x] = GROUND;
                        pacman.x += 1;
                        pacmanAction();

                        pacmanDir = "right";
                        setPacmanDirection(pacmanDir);
                    }
                } else if (e.key === "ArrowDown") {
                    if (MAP[pacman.y + 1][pacman.x] !== WALL) {
                        if (!(pacman.y + 1 === 9 && pacman.x === 9)) {
                            $('div').remove();
                            MAP[pacman.y][pacman.x] = GROUND;
                            pacman.y += 1;
                            pacmanAction();

                            pacmanDir = "down";
                            setPacmanDirection(pacmanDir);
                        }
                    }
                }
            }
        });
    }

    function moveBlinky(){
        let blinkyDir = Math.floor(Math.random() * 4 + 1);
        ghostDirection(blinkyDir, blinky, BLINKY, prevFieldBlinky);
    }
    function moveInky(){
        let inkyDir = Math.floor(Math.random() * 4 + 1);
        ghostDirection(inkyDir, inky, INKY, prevFieldInky);
    }
    function movePinky(){
        let pinkyDir = Math.floor(Math.random() * 4 + 1);
        ghostDirection(pinkyDir, pinky, PINKY, prevFieldPinky);
    }
    function moveClyde(){
        let clydeDir = Math.floor(Math.random() * 4 + 1);
        ghostDirection(clydeDir, clyde, CLYDE, prevFieldClyde);
    }


   function moveGhosts() {
       $('div').remove();
       moveBlinky();
       moveInky();
       movePinky();
       moveClyde();
       drawMap();
       setPacmanDirection(pacmanDir);
       if (!eatable){
           setTimeout(playSiren,4000);
       } else {
           playEscape();
       }
   }

    function ghostDirection(direction, ghost, field, prevField) {
        switch (direction){
            case 1: //bal
                if (MAP[ghost.y][ghost.x - 1] !== WALL) {
                    MAP[ghost.y][ghost.x] = prevField;
                    if(MAP[ghost.y][ghost.x - 1] === GROUND){
                        prevField=GROUND;
                        ghost.x -= 1;
                        MAP[ghost.y][ghost.x] = field;

                    } else if (MAP[ghost.y][ghost.x - 1] === PILL){
                        prevField=PILL;
                        ghost.x -= 1;
                        MAP[ghost.y][ghost.x] = field;

                    } else if (MAP[ghost.y][ghost.x - 1] === COIN){
                        prevField=COIN;
                        ghost.x -= 1;
                        MAP[ghost.y][ghost.x] = field;
                    } else if (MAP[ghost.y][ghost.x - 1] === PACMAN){
                        if (!eatable) {
                            prevField = GROUND;
                            ghost.x -= 1;
                            MAP[ghost.y][ghost.x] = field;
                            reduceLives();
                            playGhostEaten();
                        }
                    }
                }
                if (MAP[ghost.y][ghost.x - 1] === WALL){
                    direction = Math.floor(Math.random() * 4 + 1);
                }
                break;
            case 2: //fel
                if (MAP[ghost.y - 1][ghost.x] !== WALL) {
                    MAP[ghost.y][ghost.x] = prevField;
                    if(MAP[ghost.y - 1][ghost.x] === GROUND){
                        prevField=GROUND;
                        ghost.y -= 1;
                        MAP[ghost.y][ghost.x] = field;

                    } else if (MAP[ghost.y - 1][ghost.x] === PILL){
                        prevField=PILL;
                        ghost.y -= 1;
                        MAP[ghost.y][ghost.x] = field;

                    } else if (MAP[ghost.y - 1][ghost.x] === COIN){
                        prevField=COIN;
                        ghost.y -= 1;
                        MAP[ghost.y][ghost.x] = field;
                    } else if (MAP[ghost.y - 1][ghost.x] === PACMAN){
                        if (!eatable) {
                            prevField = GROUND;
                            ghost.y -= 1;
                            MAP[ghost.y][ghost.x] = field;
                            reduceLives();
                            playGhostEaten();
                        }
                    }
                }
                if (MAP[ghost.y - 1][ghost.x] === WALL){
                    direction = Math.floor(Math.random() * 4 + 1);
                }
                break;

            case 3: //jobb
                if (MAP[ghost.y][ghost.x + 1] !== WALL) {
                    MAP[ghost.y][ghost.x] = prevField;
                    if(MAP[ghost.y][ghost.x + 1] === GROUND){
                        prevField=GROUND;
                        ghost.x += 1;
                        MAP[ghost.y][ghost.x] = field;

                    } else if (MAP[ghost.y][ghost.x + 1] === PILL){
                        prevField=PILL;
                        ghost.x += 1;
                        MAP[ghost.y][ghost.x] = field;

                    } else if (MAP[ghost.y][ghost.x + 1] === COIN){
                        prevField=COIN;
                        ghost.x += 1;
                        MAP[ghost.y][ghost.x] = field;
                    } else if (MAP[ghost.y][ghost.x + 1] === PACMAN){
                        if (!eatable) {
                            prevField = GROUND;
                            ghost.x += 1;
                            MAP[ghost.y][ghost.x] = field;
                            reduceLives();
                            playGhostEaten();
                        }
                    }
                }
                if (MAP[ghost.y][ghost.x + 1] === WALL){
                    direction = Math.floor(Math.random() * 4 + 1);
                }
                break;
            case 4: //le
                if ((ghost.x !== 9 && ghost.y !== 9) || (ghost.x !== 9 && ghost.y !== 8)) {
                    if (MAP[ghost.y + 1][ghost.x] !== WALL) {
                        MAP[ghost.y][ghost.x] = prevField;
                        if (MAP[ghost.y + 1][ghost.x] === GROUND) {
                            prevField = GROUND;
                            ghost.y += 1;
                            MAP[ghost.y][ghost.x] = field;

                        } else if (MAP[ghost.y + 1][ghost.x] === PILL) {
                            prevField = PILL;
                            ghost.y += 1;
                            MAP[ghost.y][ghost.x] = field;

                        } else if (MAP[ghost.y + 1][ghost.x] === COIN) {
                            prevField = COIN;
                            ghost.y += 1;
                            MAP[ghost.y][ghost.x] = field;
                        } else if (MAP[ghost.y + 1][ghost.x] === PACMAN){
                            if (!eatable){
                                prevField=GROUND;
                                ghost.y += 1;
                                MAP[ghost.y][ghost.x] = field;
                                reduceLives();
                                playGhostEaten();
                            }
                        }
                    }
                    if (MAP[ghost.y + 1][ghost.x] === WALL) {
                        direction = Math.floor(Math.random() * 4 + 1);
                    }
                }
                break;
        }
        switch (field) {
            case BLINKY:
                prevFieldBlinky = prevField;
                break;
            case INKY:
                prevFieldInky = prevField;
                break;
            case PINKY:
                prevFieldPinky = prevField;
                break;
            case CLYDE:
                prevFieldClyde = prevField;
                break;
        }
    }

    function eatGhost() {
        if (eatable) {
            $('.ghost').css({
                backgroundColor: '#cbcbcb'
            });
        }
        lunchTime = setTimeout(lunchTimeEnd, 10000);
    }

    function lunchTimeEnd() {
        clearTimeout(lunchTime);
        eatable = false;
        eatenGhost = 0;

        $('#blinky').css({
            background: 'red'
        });
        $('#pinky').css({
            background: 'pink'
        });
        $('#inky').css({
            background: 'cyan'
        });
        $('#clyde').css({
            background: 'darkorange'
        });
    }

    function setPacmanDirection(pacmandir) {
        var pacmanSelector = $('.pacmandiv');
        switch (pacmandir) {
            case "left":
                pacmanSelector.css({
                    'transform': 'scaleX(-1)'
                });
                break;

            case "up":
                pacmanSelector.css({
                    'transform': 'rotate(-90deg)'
                });
                break;

            case "right":
                pacmanSelector.css({
                    'transform': 'scaleX(1)'
                });
                break;

            case "down":
                pacmanSelector.css({
                    'transform': 'rotate(90deg)'
                });
                break;
        }
    }

    function pacmanAction() {
        if (MAP[pacman.y][pacman.x] === COIN) {
            playEating();
            score += 10;
            coins-=1;
            if (coins === 0){
                gameOver();
            }
        }
        if (MAP[pacman.y][pacman.x] === PILL) {
            playEatPill();
            eatable = true;
        }
        if ((MAP[pacman.y][pacman.x] === BLINKY) || (MAP[pacman.y][pacman.x] === INKY)
            || (MAP[pacman.y][pacman.x] === PINKY) || (MAP[pacman.y][pacman.x] === CLYDE)) {
            if(eatable) {
                playEatGhost();
                eatenGhost++;
                switch (eatenGhost) {
                    case 1:
                        score += 200;
                        break;
                    case 2:
                        score += 400;
                        break;
                    case 3:
                        score += 800;
                        break;
                    case 4:
                        score += 1600;
                        break;
                }
                if (MAP[pacman.y][pacman.x] === BLINKY){
                    resetBlinkyPos();

                } else if (MAP[pacman.y][pacman.x] === INKY){
                    resetInkyPos();

                } else if (MAP[pacman.y][pacman.x] === PINKY) {
                    resetPinkyPos();

                } else if (MAP[pacman.y][pacman.x] === CLYDE) {
                    resetClydePos();
                }
            } else if (!eatable){
                reduceLives();
            }
        }

        if (pacman.y === 10 && pacman.x === 19) { //jobb exit
            pacman.x = 0;
            pacman.y = 10;
            MAP[pacman.y][pacman.x] = PACMAN;
        } else if (pacman.y === 10 && pacman.x === -1){ //bal exit
            pacman.x=18;
            pacman.y=10;
            MAP[pacman.y][pacman.x] = PACMAN;
        } else {
            MAP[pacman.y][pacman.x] = PACMAN;
        }
        drawMap();

    }

    function reduceLives() {
        lives--;
        if (lives <= 0) {
            playDie();
            gameOver();
        } else {
            resetPacmanPos();
        }
    }

    function resetPacmanPos(){
        pacman.x = 9;
        pacman.y = 16;
        MAP[pacman.y][pacman.x] = PACMAN;
        pacmanDir = "right";
    }

    function resetBlinkyPos(){
        blinky.x = 9;
        blinky.y = 9;
        MAP[blinky.y][blinky.x] = BLINKY;
        prevFieldBlinky = GROUND;
    }
    function resetInkyPos(){
        inky.x = 8;
        inky.y = 10;
        MAP[inky.y][inky.x] = INKY;
        prevFieldInky = GROUND;
    }
    function resetPinkyPos(){
        pinky.x = 9;
        pinky.y = 10;
        MAP[pinky.y][pinky.x] = PINKY;
        prevFieldPinky = GROUND;
    }
    function resetClydePos(){
        clyde.x = 10;
        clyde.y = 10;
        MAP[clyde.y][clyde.x] = CLYDE;
        prevFieldClyde = GROUND;
    }

    function gameOver() {
        is_animate = false;
        clearInterval(mg);
        $('div').remove();
        $('<div class="gameover"></div>').appendTo('body');
        $('<div id="title"></div>').appendTo('.gameover');
        $('#title').text('TOPLISTA');
        $('<div id="list"></div>').appendTo('.gameover');
        $('<span id="restartgame"></span>').appendTo('.gameover');
        delay = setTimeout(getName, 1000);
        var restart = $('#restartgame');
        restart.text('RESTART');
        restart.click(function () {
            clearTimeout(delay);
            location.reload();
        });
    }
    function getName() {
        clearTimeout(delay);
        var player = prompt("Adja meg a nevét:", "unknown");
        // eltaroljuk localStorage-ben az aktualis jatekos klikkeleseinek szamat
        localStorage.setItem(player, score);

        // feltoltjuk a toplistat
        fill_toplist();
    }

    function fill_toplist() {
        // vegigmegyunk a localStorage mentett elemein es egy uj tombbe pakoljuk. asszociativ tomb
        var data = [];
        for (var i = 0; i < localStorage.length; i++) {
            data[i] = [localStorage.key(i), parseInt(localStorage.getItem(localStorage.key(i)))];
        }
        // csokkeno sorrendbe rendezzuk az elemeket az elert pontszam alapjan
        data.sort(function (a, b) {
            return b[1] - a[1];
        });
        // a 10 legtobb pontot elert jatekost jelezzuk ki a listan
        var place = 0;
        for (let act_data of data.keys()) {
            if (2 <= act_data <= 12) {
                place++;
                $('#list').append(place +'. '+data[act_data][0] + ' - ' + data[act_data][1] + '<br>');
            }
        }
    }

    function playReady() {
        var ready = document.getElementById("ready");
        ready.play();
    }

    function playDie() {
        var die = document.getElementById("die");
        die.play();
    }

    function playEatPill() {
        var eatpill = document.getElementById("eatpill");
        eatpill.play();
    }

    function playEating() {
        var eating = document.getElementById("eating");
        eating.play();
    }

    function playEatGhost() {
        var eatghost = document.getElementById("eatghost");
        eatghost.play();
    }

    function playGhostEaten() {
        var ghosteaten = document.getElementById("ghosteaten");
        ghosteaten.play();
    }

    function playSiren() {
        var siren = document.getElementById("siren");
        siren.play();
    }

    function playEscape() {
        var escape = document.getElementById("escape");
        escape.play();
    }

    function animate() {
        if (is_animate) {
            movePacman();
            mg = setInterval(moveGhosts, 500);
        }
        // minden frameben meghivom a draw fuggvenyt
        drawMap();
        playReady();
    }