<?php
header('Content-Type: application/json');

// Oturum başlat (yarışmacının ilerlemesini takip etmek için)
session_start();

// Scenario verileri (scenario.js ile aynı yapıda)
$scenario = [
    [
        "question" => "Gözlerini açtığında kendini karanlık, nemli bir odadasın. Ayak bileğin zincirlenmiş, karşında titreyen bir lamba ve duvarda kanla yazılmış bir mesaj var: 'Oyun başladı.' Masanın üzerinde 5 nesne var. Hangisiyle zincirlerini çözüp bu cehennemden kaçabilirsin?",
        "options" => ["Paslı Bıçak", "Kırık Ayna Parçası", "Eski Bir Anahtar", "Saç Tokası", "Kör Bir Testere"],
        "answer" => ["Kör Bir Testere"],
        "loseOptions" => ["Paslı Bıçak", "Kırık Ayna Parçası", "Eski Bir Anahtar", "Saç Tokası"],
        "loseMessages" => [
            "Paslı bıçakla zinciri kesmeye çalışırken bileğini kestin ve kan kaybından öldün.",
            "Kırık Ayna Parçasıyla kurtulmaya çalışırken bileğini kestin ve kan kaybından öldün.",
            "Eski anahtarla zinciri çözmeye çalıştığında, zincir kırıldı ve susuz kalarak öldün.",
            "Saç tokası ile zinciri çözmeye çalıştığında, zincir kırıldı ve susuz kalarak öldün."
        ]
    ],
    [
        "question" => "Zincirlerden kurtuldun ancak oda kilitli. Duvarlarda 5 sembol var. Hangi sembol kapıyı açacak şifreyi oluşturuyor?",
        "options" => ["Güneş Sembolü", "Yıldız Sembolü", "Su Sembolü", "Ateş Sembolü", "Toprak Sembolü"],
        "answer" => ["Toprak Sembolü"],
        "loseOptions" => ["Güneş Sembolü", "Yıldız Sembolü", "Su Sembolü", "Ateş Sembolü"],
        "loseMessages" => [
            "Güneş sembolünü seçtin. Kapı açılmadı ve odanın tavanından zehirli gaz sızmaya başladı.",
            "Yıldız sembolünü seçtin. Kapı açılmadı ve odanın zemininden sivri kazıklar yükselmeye başladı.",
            "Su sembolünü seçtin. Kapı açılmadı ve odanın duvarlarından buz gibi sular akmaya başladı.",
            "Ateş sembolünü seçtin, ve tavandaki oklar üzerine yağmaya başladı."
        ]
    ],
    [
        "question" => "Kapı açıldı ve dar bir koridora girdin. Koridorun sonunda 5 kapı var. Her kapının üzerinde bir sayı yazıyor. Hangi kapı seni güvenli bir yere götürecek?",
        "options" => ["13", "17", "21", "79", "37"],
        "answer" => ["79"],
        "loseOptions" => ["13", "17", "21", "37"],
        "loseMessages" => [
            "13 numaralı kapıyı seçtin. Ancak odada seni bekleyen keskin bıçaklar var.",
            "17 numaralı kapıyı seçtin. Kapının arkasında asit dolu bir havuz var.",
            "21 numaralı kapıyı seçtin. Kapının arkasında alevlerle dolu bir oda var.",
            "37 numaralı kapıyı seçtin. Kapının arkasında seni parçalayacak dev bir dişli çark var."
        ]
    ],
    [
        "question" => "Güvenli bir odaya girdin ancak odanın çıkışında 5 bulmaca var. Hangi bulmacayı çözerek çıkış kapısını açabilirsin?",
        "options" => ["Labirent Bulmacası", "Şifreli Kelime Bulmacası", "Mantık Bulmacası", "Matematik Bulmacası", "Ses Bulmacası"],
        "answer" => ["Şifreli Kelime Bulmacası"],
        "loseOptions" => ["Labirent Bulmacası", "Mantık Bulmacası", "Matematik Bulmacası", "Ses Bulmacası"],
        "loseMessages" => [
            "Labirent bulmacasını çözmeye çalışırken labirentin duvarları hareket etti ve seni ezdi.",
            "Mantık bulmacası çözmeye çalışırken odanın zemini kaymaya başladı ve seni aşağıya çekti.",
            "Matematik bulmacasını çözmeye çalışırken karşına boğaziçiliden diferansiyel videosu çıktı.",
            "Ses bulmacasını çözmeye çalışırken odanın hoparlörlerinden yüksek frekanslı bir ses çıktı ve beynini parçaladı."
        ]
    ],
    [
        "question" => "Çıkış kapısı açıldı ve bir tünele girdin. Tünelin sonunda 5 farklı yol var. Hangi yolu takip ederek çıkışa ulaşabilirsin?",
        "options" => ["Işıkla Aydınlatılmış Yol", "Su Dolu Yol", "Alevli Yol", "Zehirli Gazlı Yol", "Tuzaklı Yol"],
        "answer" => ["Zehirli Gazlı Yol"],
        "loseOptions" => ["Işıkla Aydınlatılmış Yol", "Su Dolu Yol", "Alevli Yol", "Tuzaklı Yol"],
        "loseMessages" => [
            "Işıkla aydınlatılmış yolu seçtin. Lazerler belirdi ve tüm ışınlar üzerine gelmeye başladı.",
            "Su dolu yolu seçtin. Su seviyesi yükseldi ve seni boğdu.",
            "Alevli yolu seçtin. Alevler seni yaktı ve kül etti.",
            "Tuzaklı yolu seçtin. Tuzaklar seni parçaladı ve öldürdü."
        ]
    ],
    [
        "question" => "Tünelin sonunda bir ayrıma geldin. 5 farklı yöne giden yollar var. Hangi yol, seni çıkışa götürecek?",
        "options" => ["Sağa Dönüş", "Sola Dönüş", "Düz İlerleyiş", "Yukarı Tırmanış", "Aşağı İniş"],
        "answer" => ["Sola Dönüş"],
        "loseOptions" => ["Sağa Dönüş", "Düz İlerleyiş", "Yukarı Tırmanış", "Aşağı İniş"],
        "loseMessages" => [
            "Sağa döndün ve bir uçurumdan aşağı düştün.",
            "Düz ilerledin ve tuzaklarla dolu bir odaya girdin.",
            "Yukarı tırmandın ve merdiven kırılarak karnına saplandı.",
            "Aşağı indin ve zehirli bir bataklığa saplandın."
        ]
    ],
    [
        "question" => "Çıkışa yaklaştın ancak önünde 5 engel var. Hangi engeli aşarak çıkışa ulaşabilirsin?",
        "options" => ["Alev Duvarı", "Lazer Tuzakları", "Sivri Kazıklar", "Zehirli Dartlar", "Kapanan Duvarlar"],
        "answer" => ["Kapanan Duvarlar"],
        "loseOptions" => ["Alev Duvarı", "Lazer Tuzakları", "Sivri Kazıklar", "Zehirli Dartlar"],
        "loseMessages" => [
            "Alev duvarını aşmaya çalışırken yandın.",
            "Lazerler Tuzakları devreye girdi ve seni kesti.",
            "Sivri kazıklara takıldın ve parçalandın.",
            "Zehirli dartlar seni zehirledi."
        ]
    ],
    [
        "question" => "Son engeli de aştın ve çıkış kapısına ulaştın. Kapının önünde 5 düğme var. Hangi düğmeye basarak kapıyı açabilirsin?",
        "options" => ["Kırmızı Düğme", "Mavi Düğme", "Yeşil Düğme", "Sarı Düğme", "Mor Düğme"],
        "answer" => ["Sarı Düğme"],
        "loseOptions" => ["Kırmızı Düğme", "Mavi Düğme", "Yeşil Düğme", "Mor Düğme"],
        "loseMessages" => [
            "Kırmızı düğmeye bastın ve kapı kilitlendi, odanın tavanından zehirli gaz sızmaya başladı.",
            "Mavi düğmeye bastın ve kapı kilitlendi, odanın zemini kaymaya başladı.",
            "Yeşil düğmeye bastın ve kapı kilitlendi, odanın duvarlarından alevler yükselmeye başladı.",
            "Mor düğmeye bastın ve kapı kilitlendi, odanın duvarları üzerine doğru gelmeye başladı."
        ]
    ],
    [
        "question" => "Kapı açıldı ve bir koridora girdin. Koridorun sonunda 5 farklı çıkış var. Hangi çıkış, seni güvenli bir yere götürecek?",
        "options" => ["Havalandırma Bacası", "Gizli Geçit", "Asansör Boşluğu", "Merdivenler", "Tünel"],
        "answer" => ["Merdivenler"],
        "loseOptions" => ["Havalandırma Bacası", "Gizli Geçit", "Asansör Boşluğu", "Tünel"],
        "loseMessages" => [
            "Havalandırma bacasına girdin ve sıkışarak öldün.",
            "Gizli Geçite girdin ve balporsuğu tarafınfan öldürüldün.",
            "Asansör boşluğuna indin ve düşerek öldün.",
            "Tünele girdin ve tünel çöktü."
        ]
    ],
    [
        "question" => "Güvenli bir yere ulaştın ancak peşinde Amanda olduğunu anladın. Saklanmak için 5 farklı yer var. Hangi yerde saklanarak katilden kurtulabilirsin?",
        "options" => ["Dolap", "Yatak Altı", "Tavan Arası", "Kiler", "Banyo"],
        "answer" => ["Banyo"],
        "loseOptions" => ["Dolap", "Yatak Altı", "Tavan Arası", "Kiler"],
        "loseMessages" => [
            "Dolaba saklandın ve Amanda seni buldu.",
            "Yatak altına saklandın ve Amanda seni buldu.",
            "Tavan arasına saklandın ve Amanda seni buldu.",
            "Kilere saklandın ve Amanda seni buldu."
        ]
    ],
    [
        "question" => "Amanda'dan kurtuldun ancak dışarı çıkmak için bir yol bulman gerekiyor. Etrafta 5 farklı nesne var. Hangi nesneyi kullanarak dışarı çıkabilirsin?",
        "options" => ["Balta", "Halat", "Merdiven", "Levye", "Çekiç"],
        "answer" => ["Halat"],
        "loseOptions" => ["Balta", "Merdiven", "Levye", "Çekiç"],
        "loseMessages" => [
            "Baltayı kullanmaya çalışırken kendine zarar verdin.",
            "Merdiveni kullanmaya çalışırken merdiven kırıldı ve düştün.",
            "Levyeyi kullanmaya çalıştığında oyuncak olduğunu fark ettin.",
            "Çekici kullanmaya çalışırken çekicin sapı kırıldı ve sapı karnına saplandı."
        ]
    ],
    [
        "question" => "Dışarı çıktın ancak bir labirentin ortasındasın. Labirentin çıkışına ulaşmak için 5 farklı yol var. Hangi yolu takip ederek çıkışa ulaşabilirsin?",
        "options" => ["Sağdaki Yol", "Soldaki Yol", "Düz Yol", "Yukarıdaki Yol", "Aşağıdaki Yol"],
        "answer" => ["Soldaki Yol"],
        "loseOptions" => ["Sağdaki Yol", "Düz Yol", "Yukarıdaki Yol", "Aşağıdaki Yol"],
        "loseMessages" => [
            "Sağdaki yolu seçtin ve bir çıkmaz sokağa girdin.",
            "Düz yolu seçtin ve labirentin içinde kayboldun.",
            "Yukarıdaki yolu seçtin ve bir uçurumdan aşağı düştün.",
            "Aşağıdaki yolu seçtin ve zehirli bir bataklığa saplandın."
        ]
    ],
    [
        "question" => "Labirentin çıkışına ulaştın ancak önünde 5 farklı kapı var. Hangi kapı, seni güvenli bir yere götürecek?",
        "options" => ["Demir Kapı", "Ahşap Kapı", "Cam Kapı", "Çelik Kapı", "Gizli Kapı"],
        "answer" => ["Demir Kapı"],
        "loseOptions" => ["Ahşap Kapı", "Cam Kapı", "Çelik Kapı", "Gizli Kapı"],
        "loseMessages" => [
            "Ahşap kapıyı seçtin ve kapının arkasında alevler yükselmeye başladı.",
            "Cam kapıyı seçtin ve kapı kırıldı, cam parçaları seni yaraladı.",
            "Çelik kapıyı seçtin ve kapının arkasında seni parçalayacak dev bir dişli çark var.",
            "Gizli Kapıyı seçtin ve kapının arkasında uçan bıçaklar belirdi."
        ]
    ],
    [
        "question" => "Kapılardan geçtin ama Jigsaw seni hala izliyor. Saklanmak için 5 farklı yer var. Hangisinde saklanarak kurtulabilirsin?",
        "options" => ["Dolap", "Havalandırma", "Tavan Arası", "Su Deposu", "Maske Dolabı"],
        "answer" => ["Tavan Arası"],
        "loseOptions" => ["Dolap", "Havalandırma", "Su Deposu", "Maske Dolabı"],
        "loseMessages" => [
            "Dolaba saklandın ama Jigsaw'un kuklası seni fark etti.",
            "Havalandırmaya girdin ama tıkandın ve içeride sıkışıp kaldın.",
            "Su deposuna girdin ama su seviyesi yükselmeye başladı.",
            "Maske dolabına girdin ama içeride gaz salındı ve bilincini kaybettin."
        ]
    ],
    [
        "question" => "Bir ses duydun. 'Tebrikler Dedektif. Son sınavına ulaştın. Saplantın seni bu noktaya kadar getirdi. Önünde 5 kapı var. Birini seçmen gerek",
        "options" => ["Güvenli Kapı", "Kırmızı Kapı", "Sarı Kapı", "Yeşil Kapı", "Mavi Kapı"],
        "answer" => ["Güvenli Kapı"],
        "loseOptions" => ["Kırmızı Kapı", "Sarı Kapı", "Yeşil Kapı", "Mavi Kapı"],
        "loseMessages" => [
            "Saplantın seni kırmızı kapıya yönlendirdi ve kapının arkasındaki patlayıcı tetiklendi.",
            "Saplantın seni sarı kapıya yönlendirdi ve kapının arkasındaki patlayıcı tetiklendi.",
            "Saplantın seni yeşil kapıya yönlendirdi ve kapının arkasındaki patlayıcı tetiklendi.",
            "Saplantın seni mavi kapıya yönlendirdi ve kapının arkasındaki patlayıcı tetiklendi."
        ]
    ]
];



// Toplam adım sayısı
$totalSteps = count($scenario);

// Yarışmacının mevcut adımını oturumda sakla
if (!isset($_SESSION['step'])) {
    $_SESSION['step'] = 0;
}

// İstemciden gelen komut
$command = isset($_POST['command']) ? $_POST['command'] : null;

// Komut kontrolü
if ($command === 'reset') {
    $_SESSION['step'] = 0;
    echo json_encode(['success' => true, 'step' => 0, 'message' => 'Oyun sıfırlandı.']);
    exit;
}

if ($command === null) {
    echo json_encode(['success' => false, 'message' => 'Komut gönderilmedi.']);
    exit;
}

// Mevcut adım
$currentStep = $_SESSION['step'];

// Mevcut adımın verileri (eğer tüm adımlar tamamlanmadıysa)
if ($currentStep < $totalSteps) {
    $step = $scenario[$currentStep];
}

// Komut doğru mu?
if ($currentStep < $totalSteps && in_array($command, $step['answer'])) {
    $_SESSION['step']++;
    if ($_SESSION['step'] >= $totalSteps) {
        // Tüm adımlar tamamlandı, final aşamasına geç
        echo json_encode([
            'success' => true,
            'step' => $_SESSION['step'],
            'finalStage' => true,
            'photos' => [
                '/assets/photo1.png',
                '/assets/photo2.png'
            ]
        ]);
    } else {
        // Mesaj olmadan sadece adım artıyor
        echo json_encode([
            'success' => true,
            'step' => $_SESSION['step']
        ]);
    }
} elseif ($currentStep < $totalSteps && in_array($command, $step['loseOptions'])) {
    // Yanlış cevap, ilgili hata mesajını döndür
    $loseIndex = array_search($command, $step['loseOptions']);
    echo json_encode([
        'success' => false,
        'step' => $currentStep,
        'message' => $step['loseMessages'][$loseIndex]
    ]);
} else {
    // Geçersiz komut veya tüm adımlar tamamlandıktan sonra geçersiz giriş
    echo json_encode([
        'success' => false,
        'step' => $currentStep,
        'message' => $currentStep >= $totalSteps ? 'Oyun bitti, başka komut gerekmez.' : 'Geçersiz komut! Dikkatli ol.'
    ]);
}

exit;