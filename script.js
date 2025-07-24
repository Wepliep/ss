const terminal = document.getElementById('terminal');
const commandInput = document.getElementById('command');
const loseScreen = document.getElementById('lose-screen');
const typingSound = new Audio('typing_sound.mp3');
const finalSound = new Audio(); // Ses dosyasını backend'den alacağız
const commandLine = document.getElementById('command-line');

let gameStarted = false;
let currentStep = 0;
let isGameOver = false;

function printToTerminal(text) {
    terminal.innerHTML += text + "<br>";
    terminal.scrollTop = terminal.scrollHeight;
}

function typeWriter(text, delay = 10) {
    let i = 0;
    typingSound.currentTime = 0;
    typingSound.play();
    return new Promise(resolve => {
        function printChar() {
            if (i < text.length) {
                terminal.innerHTML += text.charAt(i);
                i++;
                setTimeout(printChar, delay);
            } else {
                terminal.innerHTML += "<br>";
                typingSound.pause();
                resolve();
            }
        }
        printChar();
    });
}

async function showStep() {
    terminal.innerHTML = "";
    commandLine.style.display = "none";
    if (currentStep >= scenario.length) {
        commandLine.style.display = "flex";
        commandInput.focus();
        return;
    }

    let step = scenario[currentStep];
    await typeWriter(step.question);

    for (let option of step.options) {
        await typeWriter(option);
    }
    commandLine.style.display = "flex";
    commandInput.focus();
}

async function startGame() {
    commandLine.style.display = "none";
    const asciiArt = `
<pre style="font-family: monospace; white-space: pre; font-size: 0.3em; color: red;">
          GGGGGGGGGGGAAAAAAAAAA      MMMMMMMMMMMMM   EEEEEEEEEEEEEEE              OOO   VVVVVVVV                           VVVVVVVVEEEEEEEEEERRRRRRRRRR
          G:::::::::GA::::::::A   MMM::::::::::::M EE:::::::::::::::E            O:::O  V::::::V                           V::::::VE::::::::ER::::::::R
          G:::::::::GA::::::::A MM:::::::::::::::ME:::::EEEEEE::::::E           O:::::O V::::::V                           V::::::VE::::::::ER::::::::R
          GG:::::::GGAA::::::AAM:::::MMMMMMMM::::ME:::::E     EEEEEEE          O:::::::OV::::::V                           V::::::VEE::::::EERR::::::RR
            G:::::G    A::::A M:::::M       MMMMMME:::::E                     O:::::::::OV:::::V           VVVVV           V:::::V   E::::E    R::::R  
            G:::::G    A::::AM:::::M              E:::::E                    O:::::O:::::OV:::::V         V:::::V         V:::::V    E::::E    R::::R  
            G:::::G    A::::AM:::::M               E::::EEEE                O:::::O O:::::OV:::::V       V:::::::V       V:::::V     E::::E    R::::R  
            G:::::G    A::::AM:::::M    MMMMMMMMMM  EE::::::EEEEE          O:::::O   O:::::OV:::::V     V:::::::::V     V:::::V      E::::E    R::::R  
            G:::::G    A::::AM:::::M    M::::::::M    EEE::::::::EE       O:::::O     O:::::OV:::::V   V:::::V:::::V   V:::::V       E::::E    R::::R  
GGGGGGG     G:::::G    A::::AM:::::M    MMMMM::::M       EEEEEE::::E     O:::::OOOOOOOOO:::::OV:::::V V:::::V V:::::V V:::::V        E::::E    R::::R  
G:::::G     G:::::G    A::::AM:::::M        M::::M            E:::::E   O:::::::::::::::::::::OV:::::V:::::V   V:::::V:::::V         E::::E    R::::R  
G::::::G   G::::::G    A::::A M:::::M       M::::M            E:::::E  O:::::OOOOOOOOOOOOO:::::OV:::::::::V     V:::::::::V          E::::E    R::::R  
G:::::::GGG:::::::G  AA::::::AAM:::::MMMMMMMM::::MEEEEEEE     E:::::E O:::::O             O:::::OV:::::::V       V:::::::V         EE::::::EERR::::::RR
 GG:::::::::::::GG   A::::::::A MM:::::::::::::::ME::::::EEEEEE:::::EO:::::O               O:::::OV:::::V         V:::::V          E::::::::ER::::::::R
   GG:::::::::GG     A::::::::A   MMM::::::MMM:::ME:::::::::::::::EEO:::::O                 O:::::OV:::V           V:::V           E::::::::ER::::::::R
     GGGGGGGGG       AAAAAAAAAA      MMMMMM   MMMM EEEEEEEEEEEEEEE OOOOOOO                   OOOOOOOVVV             VVV            EEEEEEEEEERRRRRRRRRR    
</pre>
    `;
    printToTerminal(asciiArt);
    await typeWriter("I wanna play a game ");
    await typeWriter("İnsanlar, hayatlarının değerini ancak kaybetmek üzereyken anlarlar. Sen de anlamaya başladın, değil mi? FLAG'i istiyorsan, tek yapman gereken benimle konuşmak. Sabır en büyük erdemdir, Dedektif");
    await typeWriter("Ama sen sabırsızsın. Bu yüzden kaybedeceksin. 'GÜVENLİ KAPIDAN GEÇME!'");
    await typeWriter("Başlamak için 'start' yazın.");
    commandLine.style.display = "flex";
    commandInput.focus();
}

commandInput.addEventListener('keydown', async function(event) {
    if (event.key === 'Enter') {
        let command = commandInput.value;
        commandInput.value = "";

        if (isGameOver) {
            if (command === 'restart') {
                restartGame();
            } else {
                printToTerminal("Kaybettiniz! Restart yazarak tekrar deneyin.");
            }
        } else {
            if (command === 'start' && !gameStarted) {
                gameStarted = true;
                await showStep();
            } else if (command === 'restart') {
                restartGame();
            } else if (gameStarted) {
                // Backend'e komutu gönder
                const response = await fetch('api.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `command=${encodeURIComponent(command)}`
                });
                const data = await response.json();

                if (data.success) {
                    currentStep = data.step;
                    if (data.finalStage) {
                        // Final aşamaya geç: Ekranı siyah yap ve fotoğrafları göster
                        document.body.style.backgroundColor = 'black';
                        terminal.style.display = 'none';
                        commandLine.style.display = 'none';
                        loseScreen.style.display = 'none';

                        // Fotoğrafları ekle
                        const photoContainer = document.createElement('div');
                        photoContainer.style.display = 'flex';
                        photoContainer.style.justifyContent = 'center';
                        photoContainer.style.alignItems = 'center';
                        photoContainer.style.height = '100vh';

                        const photo1 = document.createElement('img');
                        photo1.src = data.photos[0];
                        photo1.style.width = '40%';
                        photo1.style.margin = '10px';
                        photo1.style.cursor = 'pointer'; // Sadece photo1 tıklanabilir

                        const photo2 = document.createElement('img');
                        photo2.src = data.photos[1];
                        photo2.style.width = '40%';
                        photo2.style.margin = '10px';
                        // photo2 tıklanabilir değil, cursor normal kalır

                        photoContainer.appendChild(photo1);
                        photoContainer.appendChild(photo2);
                        document.body.appendChild(photoContainer);

                        // Sadece photo1'e tıklama olayı ekle
                        photo1.onclick = async () => {
                            finalSound.src = '/get_flag.php?action=play_sound';
                            try {
                                await finalSound.play(); // Ses çalmayı başlat
                                await new Promise(resolve => finalSound.onended = resolve); // Ses bitene kadar bekle
                            } catch (error) {
                                console.error('Ses çalma hatası:', error);
                            }

                            // Ses bittikten sonra ekranı siyah yap ve bayrağı göster
                            photoContainer.remove();
                            document.body.style.backgroundColor = 'black';
                            const flagText = document.createElement('div');
                            flagText.style.color = 'white';
                            flagText.style.fontSize = '2em';
                            flagText.style.position = 'absolute';
                            flagText.style.top = '50%';
                            flagText.style.left = '50%';
                            flagText.style.transform = 'translate(-50%, -50%)';

                            // Bayrağı backend'den al
                            const flagResponse = await fetch('/get_flag.php');
                            const flagData = await flagResponse.json();
                            flagText.textContent = flagData.flag;
                            document.body.appendChild(flagText);

                            // Bayrak alındıktan sonra oyunu bitir
                            gameStarted = false;
                            isGameOver = false;
                        };
                    } else if (currentStep < scenario.length) {
                        await showStep(); // Mesaj olmadan bir sonraki adıma geç
                    }
                } else {
                    printToTerminal(data.message);
                    loseScreen.innerHTML = `${data.message}<br><br>restart yazarak tekrar deneyebilirsiniz.`;
                    loseScreen.style.display = "flex";
                    gameStarted = false;
                    isGameOver = true;
                }
            } else {
                printToTerminal("Geçersiz komut.");
            }
        }
    }
});

function restartGame() {
    fetch('api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'command=reset'
    }).then(() => {
        gameStarted = false;
        currentStep = 0;
        isGameOver = false;
        terminal.innerHTML = "";
        loseScreen.style.display = "none";
        document.body.style.backgroundColor = '#1E1E1E'; // Orijinal arka plan rengine dön
        startGame();
        commandInput.focus();
    });
}

startGame();
commandInput.focus();

commandInput.addEventListener('paste', (event) => {
    event.preventDefault();
});

window.onload = function() {
    commandInput.focus();
};

commandInput.addEventListener('click', function(event) {
    event.preventDefault();
    commandInput.focus();
});

terminal.addEventListener('click', function(event) {
    commandInput.focus();
});