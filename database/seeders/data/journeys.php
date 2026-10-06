<?php

// SAMPLE CONTENT for the MVP. Descriptions, itineraries, inclusions and prices are
// realistic placeholders written for launch preparation; Ecoexplore must confirm every
// detail (partners, timings, park fees, prices) before selling. Prices: IDR per person.

return [
    [
        'slug' => 'gili-dive-reef-guardians',
        'category' => 'marine',
        'region' => 'Gili Trawangan & Gili Air, North Lombok',
        'duration_days' => 2, 'duration_nights' => 1,
        'price_idr' => 3450000, 'min_pax' => 1, 'max_pax' => 8,
        'difficulty' => 'moderate', 'image' => 'assets/img/reef.svg',
        'carbon_kg_pp' => 35, 'is_featured' => true, 'sort_order' => 10,
        'community_partner' => 'Local reef-restoration dive partner (sample)',
        'title' => ['id' => 'Gili Dive & Reef Guardians', 'en' => 'Gili Dive & Reef Guardians'],
        'tagline' => ['id' => 'Menyelam, belajar, dan ikut menjaga terumbu Gili.', 'en' => 'Dive, learn and help look after the Gili reefs.'],
        'summary' => [
            'id' => 'Dua penyelaman bersama pemandu lokal, sesi pengenalan restorasi terumbu, dan satu malam di penginapan ramah lingkungan di Gili Air.',
            'en' => 'Two guided dives with local divemasters, a hands-on introduction to reef restoration and one night at a low-impact stay on Gili Air.',
        ],
        'description' => [
            'id' => 'Perjalanan singkat untuk penyelam bersertifikat (Open Water atau setara) yang ingin melihat terumbu Gili sekaligus memahami cara merawatnya. Anda akan menyelam di dua titik pilihan pemandu, mengikuti sesi singkat tentang struktur restorasi terumbu, dan membantu pemantauan sederhana di perairan dangkal. Tidak ada kendaraan bermotor di Gili: perjalanan antarpulau memakai perahu umum, dan di darat kita berjalan kaki atau bersepeda.',
            'en' => 'A short trip for certified divers (Open Water or equivalent) who want to see the Gili reefs and understand how they are cared for. You dive two sites chosen by the guide, join a short session on reef-restoration structures and help with simple monitoring in the shallows. There are no motor vehicles on the Gilis: island hops use the public boat and on land we walk or cycle.',
        ],
        'itinerary' => [
            'id' => [
                ['title' => 'Hari 1 — Bangsal ke Gili Trawangan', 'body' => 'Penjemputan di pelabuhan Bangsal, perahu umum ke Gili Trawangan. Briefing keselamatan dan etika terumbu, lalu penyelaman pertama siang hari. Sore: sesi pengenalan restorasi terumbu. Menyeberang ke Gili Air dan menginap di penginapan ramah lingkungan.'],
                ['title' => 'Hari 2 — Penyelaman pagi & pulang', 'body' => 'Penyelaman kedua di pagi hari saat arus tenang. Ikut pemantauan sederhana (foto transek) di perairan dangkal. Makan siang di warung lokal, lalu perahu kembali ke Bangsal sekitar pukul 15.00.'],
            ],
            'en' => [
                ['title' => 'Day 1 — Bangsal to Gili Trawangan', 'body' => 'Meet at Bangsal harbour, public boat to Gili Trawangan. Safety and reef-etiquette briefing, then the first dive around midday. Afternoon: introduction to reef restoration. Hop across to Gili Air and overnight at a low-impact stay.'],
                ['title' => 'Day 2 — Morning dive & return', 'body' => 'Second dive in the calm morning water. Join simple monitoring (photo transects) in the shallows. Lunch at a local warung, then the boat back to Bangsal around 3 pm.'],
            ],
        ],
        'includes' => [
            'id' => ['2 penyelaman berpemandu dengan peralatan lengkap', 'Sesi pengenalan restorasi terumbu', '1 malam penginapan ramah lingkungan (kamar berbagi)', 'Perahu umum antarpulau', 'Sarapan dan 1 kali makan siang', 'Kontribusi untuk dana restorasi terumbu setempat'],
            'en' => ['2 guided dives with full equipment', 'Reef-restoration introduction session', '1 night at a low-impact stay (twin share)', 'Public island-hopping boats', 'Breakfast and 1 lunch', 'Contribution to the local reef-restoration fund'],
        ],
        'excludes' => [
            'id' => ['Transportasi ke Bangsal', 'Asuransi selam', 'Retribusi pulau (dibayar di tempat)'],
            'en' => ['Transport to Bangsal', 'Dive insurance', 'Island levy (paid locally)'],
        ],
        'impact' => [
            'id' => 'Sebagian harga paket dialokasikan untuk perawatan struktur terumbu setempat. Kelompok kecil, tanpa sentuhan karang, dan tabir surya ramah terumbu.',
            'en' => 'Part of the price goes to the upkeep of local reef structures. Small groups, no-touch diving and reef-safe sunscreen only.',
        ],
    ],
    [
        'slug' => 'gili-islands-slow-dive-escape',
        'category' => 'marine',
        'region' => 'Gili Air & Gili Meno, North Lombok',
        'duration_days' => 3, 'duration_nights' => 2,
        'price_idr' => 5950000, 'min_pax' => 1, 'max_pax' => 8,
        'difficulty' => 'easy', 'image' => 'assets/img/gili.svg',
        'carbon_kg_pp' => 55, 'is_featured' => true, 'sort_order' => 20,
        'community_partner' => 'Local dive centre & homestay partners (sample)',
        'title' => ['id' => 'Gili Islands Slow Dive Escape', 'en' => 'Gili Islands Slow Dive Escape'],
        'tagline' => ['id' => 'Tiga hari pelan di pulau tanpa kendaraan bermotor.', 'en' => 'Three slow days on islands without motor traffic.'],
        'summary' => [
            'id' => 'Empat penyelaman santai, snorkeling bersama penyu di Gili Meno, dan dua malam di penginapan kecil milik warga.',
            'en' => 'Four relaxed dives, snorkelling with turtles off Gili Meno and two nights at small, locally owned stays.',
        ],
        'description' => [
            'id' => 'Untuk penyelam yang ingin ritme lebih pelan: penyelaman di pagi hari, siang untuk beristirahat, bersepeda keliling pulau, dan sore menikmati matahari terbenam. Cocok untuk pasangan atau penyelam yang baru kembali menyelam setelah lama tidak menyelam (tersedia sesi penyegaran).',
            'en' => 'For divers who prefer a slower rhythm: dive in the mornings, rest at midday, cycle around the island and watch the sunset. Good for couples or divers returning after a break (refresher session available).',
        ],
        'itinerary' => [
            'id' => [
                ['title' => 'Hari 1 — Tiba di Gili Air', 'body' => 'Perahu dari Bangsal, check-in, sesi penyegaran opsional di kolam, lalu penyelaman sore pertama.'],
                ['title' => 'Hari 2 — Dua penyelaman & Gili Meno', 'body' => 'Dua penyelaman pagi. Siang bersepeda atau beristirahat. Sore snorkeling di Gili Meno dengan pemandu yang menjaga jarak aman dari penyu.'],
                ['title' => 'Hari 3 — Penyelaman terakhir', 'body' => 'Penyelaman pagi, sarapan santai, check-out dan perahu kembali ke Bangsal sebelum siang.'],
            ],
            'en' => [
                ['title' => 'Day 1 — Arrive on Gili Air', 'body' => 'Boat from Bangsal, check in, optional pool refresher, then the first afternoon dive.'],
                ['title' => 'Day 2 — Two dives & Gili Meno', 'body' => 'Two morning dives. Midday cycling or rest. Late-afternoon snorkel off Gili Meno with a guide who keeps a respectful distance from the turtles.'],
                ['title' => 'Day 3 — Last dive', 'body' => 'Morning dive, slow breakfast, check out and boat back to Bangsal before noon.'],
            ],
        ],
        'includes' => [
            'id' => ['4 penyelaman berpemandu dengan peralatan', 'Snorkeling Gili Meno', '2 malam penginapan milik warga (kamar berbagi)', 'Sarapan setiap hari', 'Sewa sepeda 1 hari', 'Perahu umum pulang-pergi'],
            'en' => ['4 guided dives with equipment', 'Gili Meno snorkel', '2 nights at locally owned stays (twin share)', 'Daily breakfast', '1-day bicycle hire', 'Return public boat'],
        ],
        'excludes' => [
            'id' => ['Makan siang dan malam', 'Asuransi selam', 'Retribusi pulau'],
            'en' => ['Lunches and dinners', 'Dive insurance', 'Island levy'],
        ],
        'impact' => [
            'id' => 'Menginap dan makan di usaha milik warga pulau; botol isi ulang disediakan untuk mengurangi sampah plastik.',
            'en' => 'Stay and eat at island-owned businesses; refillable bottles provided to cut plastic waste.',
        ],
    ],
    [
        'slug' => 'rinjani-responsible-trek',
        'category' => 'national_park',
        'region' => 'Sembalun, Mount Rinjani National Park',
        'duration_days' => 2, 'duration_nights' => 1,
        'price_idr' => 2850000, 'min_pax' => 2, 'max_pax' => 10,
        'difficulty' => 'challenging', 'image' => 'assets/img/rinjani.svg',
        'carbon_kg_pp' => 25, 'is_featured' => true, 'sort_order' => 30,
        'community_partner' => 'Licensed Sembalun trekking organiser (sample)',
        'title' => ['id' => 'Rinjani Responsible Trek', 'en' => 'Rinjani Responsible Trek'],
        'tagline' => ['id' => 'Bermalam di bibir kawah Sembalun, tanpa meninggalkan jejak.', 'en' => 'A night on the Sembalun crater rim, leaving no trace.'],
        'summary' => [
            'id' => 'Pendakian 2 hari 1 malam ke bibir kawah Sembalun bersama pemandu dan porter berlisensi yang dibayar layak, dengan prinsip tanpa jejak.',
            'en' => 'A 2-day, 1-night climb to the Sembalun crater rim with licensed, fairly paid guides and porters, following leave-no-trace principles.',
        ],
        'description' => [
            'id' => 'Rute paling populer untuk melihat Segara Anak dari ketinggian sekitar 2.600 mdpl. Pendakian cukup berat (6–8 jam di hari pertama) dan memerlukan kebugaran yang baik. Semua sampah dibawa turun, porter mendapatkan upah layak dan perlengkapan yang memadai, dan kelompok dibatasi agar jalur tidak padat.',
            'en' => 'The classic route to look down on Segara Anak lake from around 2,600 m. The climb is demanding (6–8 hours on day one) and needs good fitness. All waste is carried down, porters are fairly paid and properly equipped, and groups are capped to keep the trail uncrowded.',
        ],
        'itinerary' => [
            'id' => [
                ['title' => 'Hari 1 — Sembalun ke bibir kawah', 'body' => 'Briefing pagi di Sembalun, registrasi taman nasional, pendakian melalui padang savana ke Pos 3 lalu tanjakan menuju bibir kawah. Berkemah dan makan malam dengan pemandangan matahari terbenam.'],
                ['title' => 'Hari 2 — Matahari terbit & turun', 'body' => 'Bangun untuk matahari terbit di atas Segara Anak. Sarapan, aksi bersih jalur singkat, lalu turun ke Sembalun. Tiba sekitar pukul 14.00.'],
            ],
            'en' => [
                ['title' => 'Day 1 — Sembalun to the crater rim', 'body' => 'Morning briefing in Sembalun, national-park registration, trek across the savannah to Post 3 then the climb to the crater rim. Camp and dinner with the sunset.'],
                ['title' => 'Day 2 — Sunrise & descent', 'body' => 'Wake for sunrise over Segara Anak. Breakfast, a short trail clean-up, then descend to Sembalun. Arrive around 2 pm.'],
            ],
        ],
        'includes' => [
            'id' => ['Pemandu dan porter berlisensi', 'Tiket masuk taman nasional', 'Tenda, matras, kantong tidur', 'Semua makan selama pendakian', 'Air minum dan perlengkapan masak', 'Kantong sampah dan aksi bersih jalur'],
            'en' => ['Licensed guide and porters', 'National-park entrance fees', 'Tent, mat and sleeping bag', 'All meals on the trek', 'Drinking water and cooking gear', 'Waste bags and trail clean-up'],
        ],
        'excludes' => [
            'id' => ['Transportasi ke Sembalun', 'Asuransi perjalanan', 'Tip untuk pemandu dan porter'],
            'en' => ['Transport to Sembalun', 'Travel insurance', 'Tips for guides and porters'],
        ],
        'impact' => [
            'id' => 'Upah porter layak, batas beban yang wajar, dan semua sampah dibawa turun. Jalur dapat ditutup oleh taman nasional pada musim hujan.',
            'en' => 'Fair porter wages, sensible load limits and all waste carried out. The park may close the trail in the wet season.',
        ],
    ],
    [
        'slug' => 'rinjani-trek-mountain-stewardship',
        'category' => 'national_park',
        'region' => 'Sembalun – Segara Anak – Senaru, Mount Rinjani National Park',
        'duration_days' => 5, 'duration_nights' => 4,
        'price_idr' => 7900000, 'min_pax' => 2, 'max_pax' => 8,
        'difficulty' => 'challenging', 'image' => 'assets/img/rinjani-lake.svg',
        'carbon_kg_pp' => 60, 'is_featured' => true, 'sort_order' => 40,
        'community_partner' => 'Licensed Senaru & Sembalun trekking cooperative (sample)',
        'title' => ['id' => 'Rinjani Trek & Mountain Stewardship', 'en' => 'Rinjani Trek & Mountain Stewardship'],
        'tagline' => ['id' => 'Puncak, danau, dan kerja nyata menjaga gunung.', 'en' => 'Summit, lake and real work caring for the mountain.'],
        'summary' => [
            'id' => 'Lintas Rinjani 5 hari dari Sembalun ke Senaru: bibir kawah, puncak opsional, Danau Segara Anak, dan satu hari kegiatan pelestarian bersama tim lokal.',
            'en' => 'A 5-day Rinjani traverse from Sembalun to Senaru: crater rim, optional summit, Segara Anak lake and a day of stewardship work with the local team.',
        ],
        'description' => [
            'id' => 'Perjalanan paling lengkap di Rinjani dengan ritme yang lebih manusiawi. Hari tambahan memberi waktu untuk aklimatisasi, berendam di sumber air panas dekat danau, dan bergabung dengan kegiatan bersih jalur serta pencatatan kondisi jalur bersama pemandu. Puncak (3.726 mdpl) bersifat opsional dan tergantung cuaca serta kondisi peserta.',
            'en' => 'The most complete Rinjani journey at a more humane pace. The extra day allows acclimatisation, a soak in the hot springs near the lake and time to join trail clean-up and trail-condition logging with the guides. The summit (3,726 m) is optional and depends on weather and the group.',
        ],
        'itinerary' => [
            'id' => [
                ['title' => 'Hari 1 — Sembalun ke bibir kawah', 'body' => 'Registrasi, pendakian melalui savana, berkemah di bibir kawah Sembalun.'],
                ['title' => 'Hari 2 — Puncak opsional & turun ke danau', 'body' => 'Pendakian puncak dini hari (opsional). Kembali ke kemah, lalu turun ke Danau Segara Anak. Sore berendam di sumber air panas.'],
                ['title' => 'Hari 3 — Hari pelestarian di danau', 'body' => 'Bersih area kemah danau, pencatatan kondisi jalur, dan diskusi dengan pemandu tentang pengelolaan sampah di gunung. Sore bebas.'],
                ['title' => 'Hari 4 — Danau ke bibir kawah Senaru', 'body' => 'Mendaki ke bibir kawah Senaru dengan pemandangan danau dan Gunung Barujari. Berkemah.'],
                ['title' => 'Hari 5 — Turun ke Senaru', 'body' => 'Turun melalui hutan hujan ke desa Senaru. Makan siang dan transfer.'],
            ],
            'en' => [
                ['title' => 'Day 1 — Sembalun to the crater rim', 'body' => 'Registration, trek across the savannah, camp on the Sembalun crater rim.'],
                ['title' => 'Day 2 — Optional summit & down to the lake', 'body' => 'Pre-dawn summit climb (optional). Back to camp, then descend to Segara Anak lake. Afternoon soak in the hot springs.'],
                ['title' => 'Day 3 — Stewardship day at the lake', 'body' => 'Lake-camp clean-up, trail-condition logging and a talk with the guides about waste management on the mountain. Free afternoon.'],
                ['title' => 'Day 4 — Lake to the Senaru rim', 'body' => 'Climb to the Senaru crater rim with views over the lake and Mount Barujari. Camp.'],
                ['title' => 'Day 5 — Down to Senaru', 'body' => 'Descend through the rainforest to Senaru village. Lunch and transfer.'],
            ],
        ],
        'includes' => [
            'id' => ['Pemandu dan porter berlisensi', 'Tiket taman nasional', 'Perlengkapan kemah lengkap', 'Semua makan selama pendakian', 'Transfer Senaru ke Sembalun/Senggigi', 'Kegiatan pelestarian dan perlengkapannya'],
            'en' => ['Licensed guides and porters', 'National-park fees', 'Full camping equipment', 'All meals on the trek', 'Transfer Senaru to Sembalun/Senggigi', 'Stewardship activities and equipment'],
        ],
        'excludes' => [
            'id' => ['Asuransi perjalanan', 'Penginapan sebelum dan sesudah pendakian', 'Tip'],
            'en' => ['Travel insurance', 'Accommodation before and after the trek', 'Tips'],
        ],
        'impact' => [
            'id' => 'Satu hari penuh untuk pelestarian, upah porter layak, dan pembagian pendapatan antara tim Sembalun dan Senaru.',
            'en' => 'A full day of stewardship, fair porter wages and income shared between the Sembalun and Senaru teams.',
        ],
    ],
    [
        'slug' => 'sembalun-highlands-slow-escape',
        'category' => 'geopark',
        'region' => 'Sembalun Valley, East Lombok',
        'duration_days' => 2, 'duration_nights' => 1,
        'price_idr' => 1950000, 'min_pax' => 1, 'max_pax' => 10,
        'difficulty' => 'easy', 'image' => 'assets/img/sembalun.svg',
        'carbon_kg_pp' => 18, 'sort_order' => 50,
        'community_partner' => 'Sembalun farm homestay network (sample)',
        'title' => ['id' => 'Sembalun Highlands Slow Escape', 'en' => 'Sembalun Highlands Slow Escape'],
        'tagline' => ['id' => 'Udara sejuk, ladang, dan matahari terbit di bukit.', 'en' => 'Cool air, farm fields and a hilltop sunrise.'],
        'summary' => [
            'id' => 'Menginap di homestay petani di lembah Sembalun, berjalan di ladang sayur, dan mendaki bukit pendek untuk matahari terbit.',
            'en' => 'Stay with a farming family in the Sembalun valley, walk the vegetable fields and climb a short hill for sunrise.',
        ],
        'description' => [
            'id' => 'Alternatif santai bagi yang ingin merasakan Rinjani tanpa pendakian berat. Lembah Sembalun berada di ketinggian sekitar 1.100 mdpl dengan udara sejuk, ladang sayur dan stroberi, serta rumah adat. Anda akan belajar tentang pertanian dataran tinggi dan menikmati masakan rumahan.',
            'en' => 'An easy-going way to feel Rinjani without the big climb. The Sembalun valley sits at around 1,100 m with cool air, vegetable and strawberry fields and traditional houses. Learn about highland farming and enjoy home cooking.',
        ],
        'itinerary' => [
            'id' => [
                ['title' => 'Hari 1 — Lembah & ladang', 'body' => 'Tiba di Sembalun siang hari, makan siang bersama keluarga tuan rumah, berjalan di ladang bersama petani, dan sore mengunjungi kampung adat. Makan malam masakan rumahan.'],
                ['title' => 'Hari 2 — Matahari terbit di bukit', 'body' => 'Pendakian pendek (1,5–2 jam) ke bukit terdekat untuk matahari terbit di atas lembah. Sarapan, memetik stroberi sesuai musim, dan pulang siang hari.'],
            ],
            'en' => [
                ['title' => 'Day 1 — Valley & fields', 'body' => 'Arrive in Sembalun around midday, lunch with the host family, walk the fields with a farmer and visit a traditional hamlet in the afternoon. Home-cooked dinner.'],
                ['title' => 'Day 2 — Hilltop sunrise', 'body' => 'Short climb (1.5–2 hours) up a nearby hill for sunrise over the valley. Breakfast, seasonal strawberry picking and depart around midday.'],
            ],
        ],
        'includes' => [
            'id' => ['1 malam homestay petani', 'Makan siang, makan malam, sarapan', 'Pemandu lokal', 'Tiket bukit dan kampung adat'],
            'en' => ['1 night farm homestay', 'Lunch, dinner and breakfast', 'Local guide', 'Hill and village entrance fees'],
        ],
        'excludes' => [
            'id' => ['Transportasi ke Sembalun (bisa dipesan: mobil + sopir)'],
            'en' => ['Transport to Sembalun (bookable: car + driver)'],
        ],
        'impact' => [
            'id' => 'Pendapatan langsung untuk keluarga petani tuan rumah dan pemandu desa.',
            'en' => 'Income goes directly to the host farming family and village guides.',
        ],
    ],
    [
        'slug' => 'remnants-of-samalas',
        'category' => 'heritage',
        'region' => 'Rinjani-Lombok UNESCO Global Geopark',
        'duration_days' => 1, 'duration_nights' => 0,
        'price_idr' => 950000, 'min_pax' => 2, 'max_pax' => 12,
        'difficulty' => 'easy', 'image' => 'assets/img/samalas.svg',
        'carbon_kg_pp' => 12, 'is_featured' => true, 'sort_order' => 60,
        'community_partner' => 'Geopark-trained local geoguide (sample)',
        'title' => ['id' => 'Remnants of Samalas', 'en' => 'Remnants of Samalas'],
        'tagline' => ['id' => 'Menelusuri jejak letusan besar tahun 1257.', 'en' => 'Tracing the great eruption of 1257.'],
        'summary' => [
            'id' => 'Geotour sehari mengikuti jejak letusan Samalas tahun 1257 — salah satu letusan gunung api terbesar dalam beberapa ribu tahun terakhir — melalui singkapan batuan, lanskap, dan cerita lokal.',
            'en' => 'A one-day geotour following the 1257 Samalas eruption — one of the largest volcanic eruptions of the last few thousand years — through rock outcrops, landscapes and local stories.',
        ],
        'description' => [
            'id' => 'Letusan Samalas membentuk kaldera tempat Danau Segara Anak kini berada dan mengubur permukiman lama di bawah endapan batu apung. Bersama pemandu geowisata, Anda akan melihat lapisan endapan, memahami cara ilmuwan menentukan tanggal letusan, dan mendengar bagaimana peristiwa ini tercatat dalam naskah lontar Sasak. Cocok untuk keluarga dan pelajar.',
            'en' => 'The Samalas eruption created the caldera that now holds Segara Anak lake and buried old settlements under pumice. With a geoguide you will see the deposit layers, learn how scientists dated the eruption and hear how it is remembered in Sasak palm-leaf manuscripts. Suitable for families and students.',
        ],
        'itinerary' => [
            'id' => [
                ['title' => '08.00 — Penjemputan', 'body' => 'Penjemputan di Mataram/Senggigi dan pengantar singkat tentang geopark.'],
                ['title' => '10.00 — Singkapan endapan batu apung', 'body' => 'Melihat lapisan endapan letusan dan belajar membaca urutan kejadiannya.'],
                ['title' => '12.30 — Makan siang di desa', 'body' => 'Makan siang masakan Sasak di rumah warga.'],
                ['title' => '14.00 — Lanskap kaldera & cerita lokal', 'body' => 'Titik pandang lanskap dan cerita tentang Samalas dari tetua atau pemandu desa.'],
                ['title' => '17.00 — Kembali', 'body' => 'Kembali ke hotel.'],
            ],
            'en' => [
                ['title' => '08:00 — Pick-up', 'body' => 'Pick-up in Mataram/Senggigi and a short introduction to the geopark.'],
                ['title' => '10:00 — Pumice deposit outcrops', 'body' => 'See the eruption layers and learn to read the sequence of events.'],
                ['title' => '12:30 — Village lunch', 'body' => 'Sasak home-cooked lunch.'],
                ['title' => '14:00 — Caldera landscape & local stories', 'body' => 'Landscape viewpoint and stories of Samalas from a village elder or guide.'],
                ['title' => '17:00 — Return', 'body' => 'Back to your hotel.'],
            ],
        ],
        'includes' => [
            'id' => ['Pemandu geowisata', 'Transportasi AC dari Mataram/Senggigi', 'Makan siang', 'Tiket masuk lokasi'],
            'en' => ['Geoguide', 'Air-conditioned transport from Mataram/Senggigi', 'Lunch', 'Site entrance fees'],
        ],
        'excludes' => [
            'id' => ['Minuman tambahan', 'Tip'],
            'en' => ['Extra drinks', 'Tips'],
        ],
        'impact' => [
            'id' => 'Mendukung pemandu geowisata lokal dan edukasi warisan geologi geopark.',
            'en' => 'Supports local geoguides and geopark heritage education.',
        ],
    ],
    [
        'slug' => 'lombok-food-farm-table',
        'category' => 'heritage',
        'region' => 'Mataram & Central Lombok',
        'duration_days' => 1, 'duration_nights' => 0,
        'price_idr' => 850000, 'min_pax' => 2, 'max_pax' => 10,
        'difficulty' => 'easy', 'image' => 'assets/img/food.svg',
        'carbon_kg_pp' => 8, 'sort_order' => 70,
        'community_partner' => 'Farming family & home cooks (sample)',
        'title' => ['id' => 'Lombok Food & Farm Table', 'en' => 'Lombok Food & Farm Table'],
        'tagline' => ['id' => 'Dari pasar dan sawah ke meja makan.', 'en' => 'From market and paddy to the table.'],
        'summary' => [
            'id' => 'Pasar pagi, kunjungan ke kebun keluarga, lalu memasak hidangan Sasak bersama juru masak rumahan dan makan bersama.',
            'en' => 'Morning market, a family farm visit, then cooking Sasak dishes with home cooks and eating together.',
        ],
        'description' => [
            'id' => 'Kenali rasa Lombok — pedasnya plecing kangkung, ayam taliwang, dan sambal beberuk — langsung dari sumbernya. Bahan dibeli di pasar tradisional dan dipetik di kebun, lalu dimasak bersama di dapur keluarga. Pilihan vegetarian tersedia.',
            'en' => 'Get to know the flavours of Lombok — fiery plecing kangkung, ayam taliwang and sambal beberuk — at the source. Ingredients come from a traditional market and the family garden, then we cook together in a family kitchen. Vegetarian options available.',
        ],
        'itinerary' => [
            'id' => [
                ['title' => '07.30 — Pasar pagi', 'body' => 'Berbelanja bahan bersama juru masak di pasar tradisional.'],
                ['title' => '09.30 — Kebun keluarga', 'body' => 'Berjalan di kebun dan sawah, memetik sayur dan rempah.'],
                ['title' => '11.00 — Kelas memasak', 'body' => 'Memasak 4–5 hidangan Sasak dan sambal.'],
                ['title' => '13.00 — Makan bersama', 'body' => 'Makan siang bersama keluarga, lalu kembali ke hotel.'],
            ],
            'en' => [
                ['title' => '07:30 — Morning market', 'body' => 'Shop for ingredients with the cook at a traditional market.'],
                ['title' => '09:30 — Family garden', 'body' => 'Walk the garden and paddies, pick vegetables and herbs.'],
                ['title' => '11:00 — Cooking class', 'body' => 'Cook 4–5 Sasak dishes and sambal.'],
                ['title' => '13:00 — Shared meal', 'body' => 'Lunch with the family, then back to your hotel.'],
            ],
        ],
        'includes' => [
            'id' => ['Semua bahan masakan', 'Juru masak dan pemandu', 'Makan siang', 'Transportasi dari Mataram/Senggigi', 'Resep digital'],
            'en' => ['All ingredients', 'Cook and guide', 'Lunch', 'Transport from Mataram/Senggigi', 'Digital recipes'],
        ],
        'excludes' => [
            'id' => ['Belanja pribadi di pasar'],
            'en' => ['Personal shopping at the market'],
        ],
        'impact' => [
            'id' => 'Bahan dibeli langsung dari pedagang dan petani kecil; juru masak rumahan dibayar per kelas.',
            'en' => 'Ingredients bought directly from small traders and farmers; home cooks are paid per class.',
        ],
    ],
    [
        'slug' => 'lantan-village-living-culture',
        'category' => 'heritage',
        'region' => 'Lantan, Central Lombok',
        'duration_days' => 1, 'duration_nights' => 0,
        'price_idr' => 750000, 'min_pax' => 2, 'max_pax' => 12,
        'difficulty' => 'easy', 'image' => 'assets/img/village.svg',
        'carbon_kg_pp' => 10, 'sort_order' => 80,
        'community_partner' => 'Lantan village tourism group (Pokdarwis) (sample)',
        'title' => ['id' => 'Lantan Village Living Culture', 'en' => 'Lantan Village Living Culture'],
        'tagline' => ['id' => 'Sehari bersama warga desa di kaki hutan Rinjani.', 'en' => 'A day with villagers at the edge of the Rinjani forest.'],
        'summary' => [
            'id' => 'Berjalan di desa, belajar kerajinan dan pengolahan hasil kebun, serta makan siang bersama keluarga di Desa Lantan.',
            'en' => 'Walk the village, learn crafts and how garden produce is processed, and share lunch with a family in Lantan.',
        ],
        'description' => [
            'id' => 'Desa Lantan berada di lereng selatan kawasan Rinjani. Dipandu warga, Anda akan melihat kehidupan sehari-hari: kebun campur, pengolahan kopi dan gula aren, kerajinan anyaman, serta tradisi Sasak. Kegiatan dapat berbeda sesuai musim dan agenda desa.',
            'en' => 'Lantan sits on the southern slopes of the Rinjani area. Guided by villagers, see daily life: mixed gardens, coffee and palm-sugar processing, weaving crafts and Sasak traditions. Activities vary with the season and the village calendar.',
        ],
        'itinerary' => [
            'id' => [
                ['title' => '08.30 — Sambutan desa', 'body' => 'Sambutan oleh kelompok sadar wisata dan pengenalan desa.'],
                ['title' => '09.30 — Jalan kebun', 'body' => 'Berjalan melalui kebun campur menuju tepi hutan.'],
                ['title' => '11.00 — Kopi, gula aren & anyaman', 'body' => 'Mencoba proses pengolahan dan belajar anyaman dasar.'],
                ['title' => '12.30 — Makan siang keluarga', 'body' => 'Makan siang di rumah warga.'],
                ['title' => '14.30 — Kembali', 'body' => 'Kembali ke Mataram/Senggigi.'],
            ],
            'en' => [
                ['title' => '08:30 — Village welcome', 'body' => 'Welcome by the village tourism group and an introduction to Lantan.'],
                ['title' => '09:30 — Garden walk', 'body' => 'Walk through mixed gardens to the forest edge.'],
                ['title' => '11:00 — Coffee, palm sugar & weaving', 'body' => 'Try the processing steps and learn basic weaving.'],
                ['title' => '12:30 — Family lunch', 'body' => 'Lunch in a village home.'],
                ['title' => '14:30 — Return', 'body' => 'Back to Mataram/Senggigi.'],
            ],
        ],
        'includes' => [
            'id' => ['Pemandu desa', 'Kegiatan kerajinan dan pengolahan', 'Makan siang', 'Transportasi dari Mataram/Senggigi', 'Kontribusi kas desa'],
            'en' => ['Village guide', 'Craft and processing activities', 'Lunch', 'Transport from Mataram/Senggigi', 'Village fund contribution'],
        ],
        'excludes' => [
            'id' => ['Pembelian kerajinan'],
            'en' => ['Craft purchases'],
        ],
        'impact' => [
            'id' => 'Kontribusi per tamu masuk ke kas kelompok wisata desa.',
            'en' => 'A per-guest contribution goes to the village tourism group fund.',
        ],
    ],
    [
        'slug' => 'aik-berik-geotour',
        'category' => 'geopark',
        'region' => 'Aik Berik, Central Lombok',
        'duration_days' => 1, 'duration_nights' => 0,
        'price_idr' => 800000, 'min_pax' => 2, 'max_pax' => 12,
        'difficulty' => 'moderate', 'image' => 'assets/img/waterfall.svg',
        'carbon_kg_pp' => 10, 'sort_order' => 90,
        'community_partner' => 'Aik Berik community guides (sample)',
        'title' => ['id' => 'Aik Berik Geotour', 'en' => 'Aik Berik Geotour'],
        'tagline' => ['id' => 'Air terjun, hutan, dan cerita batuan Rinjani.', 'en' => 'Waterfalls, forest and Rinjani\'s rock stories.'],
        'summary' => [
            'id' => 'Geotour sehari di Aik Berik: air terjun Benang Stokel dan Benang Kelambu, hutan lindung, dan mata air yang menghidupi desa-desa di bawahnya.',
            'en' => 'A one-day geotour in Aik Berik: the Benang Stokel and Benang Kelambu waterfalls, protected forest and the springs that feed the villages below.',
        ],
        'description' => [
            'id' => 'Aik Berik terkenal dengan air terjunnya yang mengalir dari tebing batuan vulkanik. Bersama pemandu lokal, Anda akan memahami bagaimana batuan, hutan, dan air saling terkait — dan mengapa menjaga daerah aliran sungai penting bagi pertanian di Lombok Tengah. Jalur berupa anak tangga dan jalan setapak licin; gunakan alas kaki yang baik.',
            'en' => 'Aik Berik is known for waterfalls pouring over volcanic rock walls. With a local guide, learn how rock, forest and water connect — and why protecting the watershed matters for farming in Central Lombok. The path has steps and slippery trails; wear good footwear.',
        ],
        'itinerary' => [
            'id' => [
                ['title' => '08.00 — Penjemputan', 'body' => 'Penjemputan di Mataram/Senggigi.'],
                ['title' => '09.30 — Benang Stokel', 'body' => 'Berjalan ke air terjun Benang Stokel; penjelasan tentang batuan vulkanik dan mata air.'],
                ['title' => '11.00 — Benang Kelambu', 'body' => 'Jalan hutan ke Benang Kelambu, waktu berenang di kolam yang aman.'],
                ['title' => '13.00 — Makan siang', 'body' => 'Makan siang di warung desa.'],
                ['title' => '14.00 — Kebun & DAS', 'body' => 'Kunjungan singkat ke kebun warga di hilir dan diskusi tentang daerah aliran sungai. Kembali sekitar pukul 16.30.'],
            ],
            'en' => [
                ['title' => '08:00 — Pick-up', 'body' => 'Pick-up in Mataram/Senggigi.'],
                ['title' => '09:30 — Benang Stokel', 'body' => 'Walk to Benang Stokel falls; explanation of volcanic rock and springs.'],
                ['title' => '11:00 — Benang Kelambu', 'body' => 'Forest walk to Benang Kelambu, time to swim in a safe pool.'],
                ['title' => '13:00 — Lunch', 'body' => 'Lunch at a village warung.'],
                ['title' => '14:00 — Gardens & watershed', 'body' => 'Short visit to downstream gardens and a talk about the watershed. Back around 4:30 pm.'],
            ],
        ],
        'includes' => [
            'id' => ['Pemandu lokal', 'Transportasi dari Mataram/Senggigi', 'Tiket masuk', 'Makan siang'],
            'en' => ['Local guide', 'Transport from Mataram/Senggigi', 'Entrance fees', 'Lunch'],
        ],
        'excludes' => [
            'id' => ['Ojek opsional di area parkir', 'Tip'],
            'en' => ['Optional motorbike shuttle at the car park', 'Tips'],
        ],
        'impact' => [
            'id' => 'Sebagian harga mendukung program penanaman pohon di daerah aliran sungai Aik Berik.',
            'en' => 'Part of the price supports tree planting in the Aik Berik watershed.',
        ],
    ],
    // --- Indonesia-wide additions (sample) ---
    [
        'slug' => 'komodo-island-safari',
        'category' => 'national_park',
        'region' => 'Komodo National Park, East Nusa Tenggara',
        'duration_days' => 3, 'duration_nights' => 2,
        'price_idr' => 4800000, 'min_pax' => 2, 'max_pax' => 8,
        'difficulty' => 'moderate', 'image' => 'assets/img/beach.svg',
        'carbon_kg_pp' => 95, 'is_featured' => true, 'sort_order' => 100,
        'community_partner' => 'Labuan Bajo community boat & ranger partners (sample)',
        'title' => ['id' => 'Komodo Island Safari', 'en' => 'Komodo Island Safari'],
        'tagline' => ['id' => 'Menyusuri taman nasional purba bersama ranger dan nelayan lokal.', 'en' => 'Sail the ancient national park with rangers and local fishers.'],
        'summary' => [
            'id' => 'Tiga hari berlayar dari Labuan Bajo: padar, Komodo, dan terumbu karang yang sehat, dengan tidur di kapal nelayan yang dikelola warga.',
            'en' => 'Three days sailing from Labuan Bajo: Padar, Komodo and healthy reefs, sleeping on a community-run liveaboard.',
        ],
        'description' => [
            'id' => 'Taman Nasional Komodo adalah salah satu kawasan laut paling kaya di dunia sekaligus rumah kadal purba. Perjalanan ini memakai kapal kecil milik kelompok nelayan Labuan Bajo, dengan ranger lokal di setiap pendaratan. Rute mengikuti aturan zonasi taman: snorkeling di zona penggunaan, treking singkat di Pulau Padar dan Rinca, dan menikmati manta point di luar jam ramai.',
            'en' => 'Komodo National Park is one of the richest marine areas on earth and home to the ancient dragons. This trip uses a small boat owned by a Labuan Bajo fishers\' group, with local rangers on every landing. The route follows the park\'s zoning: snorkelling in use zones, short treks on Padar and Rinca, and a manta point visit outside peak hours.',
        ],
        'itinerary' => [
            'id' => [
                ['title' => 'Hari 1 — Labuan Bajo ke Padar', 'body' => 'Berangkat pagi dari Labuan Bajo. Treking foto di bukit Padar sebelum siang, lalu snorkeling di pantai berpasir merah. Malam di atas kapal di teluk terlindung.'],
                ['title' => 'Hari 2 — Pulau Komodo & terumbu', 'body' => 'Pagi bersama ranger mencari komodo di jalur aman. Siang snorkeling di salah satu titik terumbu terbaik taman. Sore kunjungan ke desa nelayan di Pulau Komodo.'],
                ['title' => 'Hari 3 — Manta point & kembali', 'body' => 'Snorkeling bersama pari manta di jam sepi, sarapan terakhir di kapal, dan kembali ke Labuan Bajo sebelum pukul 15.00.'],
            ],
            'en' => [
                ['title' => 'Day 1 — Labuan Bajo to Padar', 'body' => 'Depart Labuan Bajo early. Photo trek on the Padar hills before midday, then snorkel at the pink-sand beach. Overnight on the boat in a sheltered bay.'],
                ['title' => 'Day 2 — Komodo Island & the reefs', 'body' => 'Morning walk with a ranger to see komodo dragons on a safe trail. Midday snorkelling at one of the park\'s best reef sites. Afternoon visit to the fishing village on Komodo Island.'],
                ['title' => 'Day 3 — Manta point & return', 'body' => 'Snorkel with manta rays outside peak hours, last breakfast on board and back in Labuan Bajo before 3 pm.'],
            ],
        ],
        'includes' => [
            'id' => ['2 malam di kapal komunitas (berbagi kabin)', 'Semua konsumsi di kapal', 'Ranger & biaya masuk taman', 'Peralatan snorkeling', 'Penjemputan di Labuan Bajo'],
            'en' => ['2 nights on the community boat (shared cabin)', 'All meals on board', 'Rangers & park fees', 'Snorkelling gear', 'Pick-up in Labuan Bajo'],
        ],
        'excludes' => [
            'id' => ['Penerbangan ke Labuan Bajo', 'Asuransi perjalanan', 'Tip kru (opsional)'],
            'en' => ['Flights to Labuan Bajo', 'Travel insurance', 'Crew tips (optional)'],
        ],
        'impact' => [
            'id' => 'Kapal dan kru dari kelompok nelayan lokal, sebagian biaya masuk taman kembali ke konservasi, dan kunjungan desa memberi pemasukan langsung kepada warga Pulau Komodo.',
            'en' => 'The boat and crew come from a local fishers\' group, part of the park fees support conservation, and the village visit gives direct income to Komodo islanders.',
        ],
    ],
    [
        'slug' => 'raja-ampat-reef-expedition',
        'category' => 'marine',
        'region' => 'Raja Ampat, Southwest Papua',
        'duration_days' => 5, 'duration_nights' => 4,
        'price_idr' => 12500000, 'min_pax' => 2, 'max_pax' => 6,
        'difficulty' => 'moderate', 'image' => 'assets/img/reef.svg',
        'carbon_kg_pp' => 220, 'is_featured' => true, 'sort_order' => 110,
        'community_partner' => 'Papua homestay network & dive guide partners (sample)',
        'title' => ['id' => 'Raja Ampat Reef Expedition', 'en' => 'Raja Ampat Reef Expedition'],
        'tagline' => ['id' => 'Lima hari di jantung segitiga terumbu dunia, menginap di homestay warga.', 'en' => 'Five days in the heart of the coral triangle, staying at village homestays.'],
        'summary' => [
            'id' => 'Menyelam dan snorkeling di perairan paling beragam di bumi, dengan homestay kayu di atas air yang dikelola keluarga lokal.',
            'en' => 'Dive and snorkel the most biodiverse waters on earth, sleeping in over-water homestays run by local families.',
        ],
        'description' => [
            'id' => 'Raja Ampat menyimpan sekitar 75% spesies karang dunia. Perjalanan ini memakai homestay jaringan warga di Kri dan Arborek, perahu kecil milik nelayan setempat, dan pemandu selam Papua bersertifikat. Grup maksimal enam orang, dengan sesi pengenalan konservasi desa adat yang mengelola kawasan.',
            'en' => 'Raja Ampat holds around 75% of the world\'s coral species. This trip uses the community homestay network on Kri and Arborek, small boats owned by local fishers, and certified Papuan dive guides. Maximum six guests, with an introduction to the customary villages that manage the area.',
        ],
        'itinerary' => [
            'id' => [
                ['title' => 'Hari 1 — Sorong ke Kri', 'body' => 'Kapal cepat dari Sorong, check-in di homestay Kri. Snorkeling penyesuaian sore di depan penginapan.'],
                ['title' => 'Hari 2 — Dua penyelaman Kri', 'body' => 'Dua penyelaman di sekitar Kri termasuk lapangan karang staghorn yang dipulihkan desa. Sore kunjungan kampung Arborek.'],
                ['title' => 'Hari 3 — Wayag utara', 'body' => 'Perjalanan jauh ke karst Wayag: treking pemandangan, snorkeling laguna, makan siang piknik di pulau kosong.'],
                ['title' => 'Hari 4 — Arborek & kabupaten laut', 'body' => 'Penyelaman pagi di titik arus lembut, senja di jembatan Arborek bersama anak-anak kampung. Malam perpisahan.'],
                ['title' => 'Hari 5 — Kembali ke Sorong', 'body' => 'Kapal pagi ke Sorong, tiba sekitar siang.'],
            ],
            'en' => [
                ['title' => 'Day 1 — Sorong to Kri', 'body' => 'Fast boat from Sorong, check in at the Kri homestay. Orientation snorkel off the deck in the afternoon.'],
                ['title' => 'Day 2 — Two Kri dives', 'body' => 'Two dives around Kri including the staghorn field the village has restored. Afternoon visit to Arborek village.'],
                ['title' => 'Day 3 — Northern Wayag', 'body' => 'Long boat ride to the Wayag karsts: viewpoint trek, lagoon snorkelling, picnic lunch on an empty islet.'],
                ['title' => 'Day 4 — Arborek & the sea park', 'body' => 'Morning dive at a gentle drift site, sunset on Arborek jetty with village kids. Farewell dinner.'],
                ['title' => 'Day 5 — Back to Sorong', 'body' => 'Morning boat to Sorong, arriving around midday.'],
            ],
        ],
        'includes' => [
            'id' => ['4 malam homestay (makan termasuk)', '6 penyelaman berpemandu', 'Perahu & kapten lokal', 'Biaya masuk kawasan adat (tarif retribusi)', 'Transfer bandara Sorong'],
            'en' => ['4 homestay nights (meals included)', '6 guided dives', 'Local boat & captain', 'Customary-area entry fees (retribution)', 'Sorong airport transfers'],
        ],
        'excludes' => [
            'id' => ['Penerbangan ke Sorong', 'Sewa peralatan selam', 'Asuransi selam'],
            'en' => ['Flights to Sorong', 'Dive gear rental', 'Dive insurance'],
        ],
        'impact' => [
            'id' => 'Hampir seluruh biaya mengalir ke homestay, kapten perahu, dan retribusi desa adat yang mengelola konservasi laut.',
            'en' => 'Almost everything you pay flows to homestays, boat captains and the customary-village retribution that funds marine conservation.',
        ],
    ],
    [
        'slug' => 'bromo-tengger-caldera',
        'category' => 'national_park',
        'region' => 'Bromo Tengger Semeru NP, East Java',
        'duration_days' => 2, 'duration_nights' => 1,
        'price_idr' => 2100000, 'min_pax' => 2, 'max_pax' => 10,
        'difficulty' => 'easy', 'image' => 'assets/img/rinjani.svg',
        'carbon_kg_pp' => 45, 'is_featured' => false, 'sort_order' => 120,
        'community_partner' => 'Tengger village jeep & homestay partners (sample)',
        'title' => ['id' => 'Bromo Tengger Caldera', 'en' => 'Bromo Tengger Caldera'],
        'tagline' => ['id' => 'Matahari terbit di kaldera vulkanik tersibuk di Jawa, tanpa terburu-buru.', 'en' => 'Sunrise over Java\'s busiest volcanic caldera, without the rush.'],
        'summary' => [
            'id' => 'Dua hari tenang di dataran tinggi Tengger: matahari terbit di Penanjakan, lautan pasir, dan desa Ngadisari dengan jeep warga.',
            'en' => 'Two slow days on the Tengger highlands: Penanjakan sunrise, the sea of sand and Ngadisari village with community jeeps.',
        ],
        'description' => [
            'id' => 'Versi Bromo yang lebih pelan: satu malam di homestay warga Tengger, jeep komunitas ke bukit Penanjakan, berjalan kaki menyeberangi lautan pasir ke kawah, dan kopi di kebun kaki gunung. Tidak ada lomba jam 3 pagi — kita berangkat lebih siang untuk menghindari keramaian.',
            'en' => 'A slower Bromo: one night at a Tengger family homestay, community jeeps to Penanjakan, a walk across the sea of sand to the crater, and coffee at a mountain farm. No 3 am race — we leave later to skip the crowds.',
        ],
        'itinerary' => [
            'id' => [
                ['title' => 'Hari 1 — Ngadisari', 'body' => 'Tiba dari Malang atau Surabaya, check-in homestay. Sore berjalan ke Pura Luhur Poten dan melihat upacara Tengger dari jarak hormat. Makan malam rumahan.'],
                ['title' => 'Hari 2 — Kaldera & kembali', 'body' => 'Jeep naik sebelum fajar ke bukit Penanjakan. Setelah matahari terbit, turun berjalan kaki menyeberangi lautan pasir ke kawah Bromo. Kopi terakhir di kebun, lalu kembali.'],
            ],
            'en' => [
                ['title' => 'Day 1 — Ngadisari', 'body' => 'Arrive from Malang or Surabaya, check in to the homestay. Late-afternoon walk to Pura Luhur Poten and a respectful look at Tengger ceremony. Home-cooked dinner.'],
                ['title' => 'Day 2 — The caldera & return', 'body' => 'Jeeps climb before dawn to Penanjakan viewpoint. After sunrise, walk across the sea of sand to the Bromo crater. Last coffee at a farm, then return.'],
            ],
        ],
        'includes' => [
            'id' => ['1 malam homestay Tengger', 'Jeep komunitas', 'Biaya masuk taman nasional', 'Makan malam & sarapan', 'Pemandu lokal'],
            'en' => ['1 night at a Tengger homestay', 'Community jeep', 'National park entrance fees', 'Dinner & breakfast', 'Local guide'],
        ],
        'excludes' => [
            'id' => ['Transportasi ke Ngadisari', 'Kuda di lautan pasir (opsional)', 'Tip pemandu'],
            'en' => ['Transport to Ngadisari', 'Horses on the sand sea (optional)', 'Guide tips'],
        ],
        'impact' => [
            'id' => 'Jeep, homestay, dan pemandu berasal dari desa Ngadisari; kunjungan ke pura dan kebun kopi memberi pemasukan langsung.',
            'en' => 'Jeeps, homestays and guides come from Ngadisari village; the temple and coffee-farm visits give direct income.',
        ],
    ],
    [
        'slug' => 'leuser-rainforest-trek',
        'category' => 'biosphere',
        'region' => 'Gunung Leuser Biosphere Reserve, Aceh',
        'duration_days' => 4, 'duration_nights' => 3,
        'price_idr' => 6900000, 'min_pax' => 2, 'max_pax' => 6,
        'difficulty' => 'challenging', 'image' => 'assets/img/forest.svg',
        'carbon_kg_pp' => 70, 'is_featured' => false, 'sort_order' => 130,
        'community_partner' => 'Ketambe guide & porter co-op (sample)',
        'title' => ['id' => 'Leuser Rainforest Trek', 'en' => 'Leuser Rainforest Trek'],
        'tagline' => ['id' => 'Empat hari menyusuri hutan hujan tertua di Ketambe, rumah orangutan liar.', 'en' => 'Four days in the oldest rainforest at Ketambe, home of wild orangutans.'],
        'summary' => [
            'id' => 'Trekking berkemah di Cagar Biosfer Gunung Leuser dengan pemandu dan porter dari koperasi desa Ketambe, mencari satwa tanpa memberi makan.',
            'en' => 'Camping trek in the Gunung Leuser Biosphere Reserve with guides and porters from the Ketambe village co-op, watching wildlife without feeding it.',
        ],
        'description' => [
            'id' => 'Leuser adalah salah satu hutan hujan tertua di dunia dan satu-satunya tempat di mana orangutan, gajah, badak, dan harimau masih berbagi hutan yang sama. Trek ini berjalan pelan di jalur Ketambe dengan aturan jarak aman dari satwa, membawa semua logistik, dan bermalam di dua kem tepi sungai. Pemandu adalah anggota koperasi warga yang menggantungkan hidup pada hutan yang lestari.',
            'en' => 'Leuser is one of the oldest rainforests on earth and the only place where orangutans, elephants, rhinos and tigers still share the same forest. This trek moves slowly on the Ketambe trails with safe wildlife distances, carries everything in and camps at two riverside camps. Guides are members of the village co-op who depend on a forest that stays standing.',
        ],
        'itinerary' => [
            'id' => [
                ['title' => 'Hari 1 — Medan ke Ketambe', 'body' => 'Perjalanan darat dari Medan ke Ketambe. Briefing satwa dan etika hutan, makan malam di guesthouse koperasi.'],
                ['title' => 'Hari 2 — Jalur besar & kem pertama', 'body' => 'Trek pagi masuk hutan. Sore berkemas di kem tepi sungai; mandi air terjun kecil. Malam dengar kantong.'],
                ['title' => 'Hari 3 — Kem kedua & jalur satwa', 'body' => 'Pindah kem sambil menyusuri jalur orangutan dan burung. Sore bersihkan sampah jalur (ikuti praktik koperasi).'],
                ['title' => 'Hari 4 — Keluar hutan', 'body' => 'Trek pagi kembali ke Ketambe, makan siang perpisahan, dan perjalanan ke Medan.'],
            ],
            'en' => [
                ['title' => 'Day 1 — Medan to Ketambe', 'body' => 'Overland from Medan to Ketambe. Wildlife and forest-ethics briefing, dinner at the co-op guesthouse.'],
                ['title' => 'Day 2 — Main trail & first camp', 'body' => 'Morning trek into the forest. Set up the riverside camp in the afternoon; small-waterfall bath. Night listening for gibbons.'],
                ['title' => 'Day 3 — Second camp & wildlife trails', 'body' => 'Move camp along orangutan and birding trails. Afternoon trail clean-up (a co-op practice).'],
                ['title' => 'Day 4 — Out of the forest', 'body' => 'Morning trek back to Ketambe, farewell lunch and the drive to Medan.'],
            ],
        ],
        'includes' => [
            'id' => ['3 malam (1 guesthouse + 2 kem)', 'Pemandu & porter koperasi', 'Semua makanan trek', 'Izin masuk kawasan', 'Transport Ketambe–Medan'],
            'en' => ['3 nights (1 guesthouse + 2 camps)', 'Co-op guides & porters', 'All trek food', 'Area permits', 'Ketambe–Medan transport'],
        ],
        'excludes' => [
            'id' => ['Transportasi ke Medan', 'Alas kaki trek (disarankan sendiri)', 'Asuransi perjalanan'],
            'en' => ['Transport to Medan', 'Trekking footwear (bring your own)', 'Travel insurance'],
        ],
        'impact' => [
            'id' => 'Seluruh tim adalah koperasi desa Ketambe — hutan yang menghasilkan dari wisata adalah hutan yang tidak ditebang.',
            'en' => 'The whole team is the Ketambe village co-op — a forest that earns from visitors is a forest that stays uncut.',
        ],
    ],
    [
        'slug' => 'ubud-subak-heritage-walk',
        'category' => 'heritage',
        'region' => 'Bali Cultural Landscape (Subak), Bali',
        'duration_days' => 3, 'duration_nights' => 2,
        'price_idr' => 3400000, 'min_pax' => 2, 'max_pax' => 8,
        'difficulty' => 'easy', 'image' => 'assets/img/village.svg',
        'carbon_kg_pp' => 50, 'is_featured' => false, 'sort_order' => 140,
        'community_partner' => 'Subak farmers\' association walk hosts (sample)',
        'title' => ['id' => 'Ubud Subak Heritage Walk', 'en' => 'Ubud Subak Heritage Walk'],
        'tagline' => ['id' => 'Berjalan pelan di antara sawah warisan dunia bersama petani subak.', 'en' => 'Walk slowly through World Heritage rice terraces with subak farmers.'],
        'summary' => [
            'id' => 'Tiga hari di lanskap budaya Bali: sawah berundak, pura air, dan masakan rumahan dari hasil kebun subak.',
            'en' => 'Three days in Bali\'s cultural landscape: terraced paddies, water temples and home cooking from the subak gardens.',
        ],
        'description' => [
            'id' => 'Sistem irigasi subak Bali diakui UNESCO sebagai warisan budaya. Perjalanan ini berjalan kaki dari Ubud ke Tegalalang dan sekitarnya bersama tuan rumah petani, belajar cara air dibagi adil antarladang, dan memasak bersama keluarga. Tanpa kunjungan kerajinan yang dipaksa.',
            'en' => 'Bali\'s subak irrigation system is a UNESCO-recognised cultural landscape. This trip walks from Ubud toward Tegalalang and beyond with farmer hosts, learning how water is shared fairly between paddies, and cooking with a family. No forced craft-shop stops.',
        ],
        'itinerary' => [
            'id' => [
                ['title' => 'Hari 1 — Ubud & pura air', 'body' => 'Check-in di guesthouse keluarga. Sore berjalan ke pura air dan belajar sistem subak dari petani. Makan malam rumahan.'],
                ['title' => 'Hari 2 — Tegalalang & dapur subak', 'body' => 'Pagi berjalan di tepian sawah Tegalalang sebelum keramaian. Siang kelas masak dari hasil kebun keluarga. Sore bebas.'],
                ['title' => 'Hari 3 — Pasar & pulang', 'body' => 'Sarapan di pasar pagi Ubud, belanja bumbu, lalu check-out.'],
            ],
            'en' => [
                ['title' => 'Day 1 — Ubud & the water temple', 'body' => 'Check in at the family guesthouse. Afternoon walk to the water temple to learn the subak system from a farmer. Home dinner.'],
                ['title' => 'Day 2 — Tegalalang & the subak kitchen', 'body' => 'Morning walk along the Tegalalang terraces before the crowds. Midday cooking class from the family garden. Free evening.'],
                ['title' => 'Day 3 — Market & departure', 'body' => 'Breakfast at Ubud morning market, spice shopping, then check-out.'],
            ],
        ],
        'includes' => [
            'id' => ['2 malam guesthouse keluarga', 'Pemandu jalan petani subak', 'Kelas masak & semua makan', 'Sarapan pasar'],
            'en' => ['2 nights at a family guesthouse', 'Subak farmer walking guide', 'Cooking class & all meals', 'Market breakfast'],
        ],
        'excludes' => [
            'id' => ['Transportasi ke Ubud', 'Kegiatan sore bebas', 'Tip tuan rumah'],
            'en' => ['Transport to Ubud', 'Free-evening activities', 'Host tips'],
        ],
        'impact' => [
            'id' => 'Biaya mengalir ke keluarga petani dan asosiasi subak yang merawat saluran air warisan.',
            'en' => 'Fees flow to farming families and the subak association that maintains the heritage water channels.',
        ],
    ],
    [
        'slug' => 'tangkahan-elephant-encounter',
        'category' => 'wildlife',
        'region' => 'Tangkahan, North Sumatra',
        'duration_days' => 3, 'duration_nights' => 2,
        'price_idr' => 5200000, 'min_pax' => 2, 'max_pax' => 6,
        'difficulty' => 'moderate', 'image' => 'assets/img/waterfall.svg',
        'carbon_kg_pp' => 80, 'is_featured' => false, 'sort_order' => 150,
        'community_partner' => 'Tangkahan mahout & jungle-guide collective (sample)',
        'title' => ['id' => 'Tangkahan Elephant Encounter', 'en' => 'Tangkahan Elephant Encounter'],
        'tagline' => ['id' => 'Bersama gajah santun dan desa penjaga hutan di gerbang Leuser.', 'en' => 'Ethical elephant time with the forest-guardian village at Leuser\'s gate.'],
        'summary' => [
            'id' => 'Tiga hari di Tangkahan: berjalan bersama gajah tanpa menunggang, tubing sungai, dan menginap di penginapan desa.',
            'en' => 'Three days in Tangkahan: walking with elephants without riding, river tubing and village-run accommodation.',
        ],
        'description' => [
            'id' => 'Tangkahan adalah desa yang mengubah logging menjadi wisata hutan. Perjalanan ini berjalan kaki bersama gajah dan pawangnya di hutan bukan sirkus, mandi sungai bersama gajah hanya bila gajah mendekat sendiri, dan tubing di sungai sebelum berkemah di tepi rimba. Semua kegiatan mengikuti aturan kesejahteraan gajah yang ditetapkan koperasi desa.',
            'en' => 'Tangkahan is a village that turned logging into forest tourism. This trip walks with elephants and their mahouts in the forest — not a circus — river baths only if the elephants choose to come, and tubing on the river before a night at the jungle\'s edge. All activities follow the welfare rules set by the village co-op.',
        ],
        'itinerary' => [
            'id' => [
                ['title' => 'Hari 1 — Medan ke Tangkahan', 'body' => 'Perjalanan darat yang indah dari Medan. Sore berjalan ke menara pandang dan sungai. Malam di penginapan desa.'],
                ['title' => 'Hari 2 — Berjalan dengan gajah', 'body' => 'Pagi berjalan kaki bersama gajah dan pawang di hutan. Siang tubing sungai. Sore membantu menanam pakan gajah di kebun koperasi.'],
                ['title' => 'Hari 3 — Air terjun & pulang', 'body' => 'Pagi ke air terjun terdekat, lalu perjalanan kembali ke Medan.'],
            ],
            'en' => [
                ['title' => 'Day 1 — Medan to Tangkahan', 'body' => 'A scenic overland drive from Medan. Late-afternoon walk to the lookout and the river. Night at the village lodge.'],
                ['title' => 'Day 2 — Walking with elephants', 'body' => 'Morning forest walk alongside elephants and their mahouts. Midday river tubing. Late afternoon helping plant elephant forage at the co-op garden.'],
                ['title' => 'Day 3 — Waterfall & return', 'body' => 'Morning at the nearby waterfall, then the drive back to Medan.'],
            ],
        ],
        'includes' => [
            'id' => ['2 malam penginapan desa', 'Jalan gajah & pawang', 'Tubing sungai', 'Semua makan', 'Izin kawasan & donasi koperasi'],
            'en' => ['2 nights at the village lodge', 'Elephant walk with mahouts', 'River tubing', 'All meals', 'Area permits & co-op donation'],
        ],
        'excludes' => [
            'id' => ['Transportasi ke Medan', 'Foto profesional (opsional)', 'Tip pawang'],
            'en' => ['Transport to Medan', 'Professional photos (optional)', 'Mahout tips'],
        ],
        'impact' => [
            'id' => 'Penginapan, pawang, dan transportasi milik koperasi desa — model yang membuat hutan Leuser lebih berharga utuh.',
            'en' => 'Lodge, mahouts and transport are village co-op owned — a model that makes Leuser\'s forest worth more standing.',
        ],
    ],
    [
        'slug' => 'wakatobi-dive-conservation',
        'category' => 'marine',
        'region' => 'Wakatobi NP, Southeast Sulawesi',
        'duration_days' => 4, 'duration_nights' => 3,
        'price_idr' => 9800000, 'min_pax' => 2, 'max_pax' => 8,
        'difficulty' => 'moderate', 'image' => 'assets/img/coral.svg',
        'carbon_kg_pp' => 140, 'is_featured' => false, 'sort_order' => 160,
        'community_partner' => 'Wangi-wangi island dive community (sample)',
        'title' => ['id' => 'Wakatobi Dive & Conservation', 'en' => 'Wakatobi Dive & Conservation'],
        'tagline' => ['id' => 'Menyelam taman laut nasional sambil ikut survei karang warga.', 'en' => 'Dive the national marine park while joining community reef surveys.'],
        'summary' => [
            'id' => 'Empat hari di Wakatobi: delapan penyelaman di atoll terbaik, satu sesi survei karang bersama warga, dan homestay tepi pantai.',
            'en' => 'Four days in Wakatobi: eight dives on the best atolls, one community reef-survey session and a beachside homestay.',
        ],
        'description' => [
            'id' => 'Wakatobi menyimpan 750 dari 850 spesies karang Indo-Pasifik. Perjalanan ini bermitra dengan kelompok penyelam desa di Wangi-wangi: dua penyelaman per hari, satu pagi diganti sesi foto transek karang untuk data konservasi desa adat, dan malam hari berbagi hasil.',
            'en' => 'Wakatobi holds 750 of the 850 Indo-Pacific coral species. This trip partners with a Wangi-wangi village dive group: two dives a day, one morning swapped for coral photo-transects feeding customary-area conservation data, and evenings comparing shots.',
        ],
        'itinerary' => [
            'id' => [
                ['title' => 'Hari 1 — Wanci', 'body' => 'Tiba di Wangi-wangi, check-in homestay, penyelaman penyesuaian sore di house reef.'],
                ['title' => 'Hari 2 — Dua penyelaman atoll', 'body' => 'Penyelaman pagi dan siang di karang luar. Malam briefing survei.'],
                ['title' => 'Hari 3 — Sesi survei karang', 'body' => 'Pagi memotret transek bersama warga, dua penyelaman sore. Malam unggah data bersama.'],
                ['title' => 'Hari 4 — Penyelaman pamungkas', 'body' => 'Dua penyelaman terakhir dan kembali ke bandara Wanci.'],
            ],
            'en' => [
                ['title' => 'Day 1 — Wanci', 'body' => 'Arrive on Wangi-wangi, homestay check-in, afternoon checkout dive on the house reef.'],
                ['title' => 'Day 2 — Two atoll dives', 'body' => 'Morning and midday dives on the outer reefs. Survey briefing in the evening.'],
                ['title' => 'Day 3 — Reef-survey session', 'body' => 'Morning photo transects with the community, two afternoon dives. Data upload together at night.'],
                ['title' => 'Day 4 — Final dives', 'body' => 'Two last dives and back to Wanci airport.'],
            ],
        ],
        'includes' => [
            'id' => ['3 malam homestay', '8 penyelaman berpemandu', 'Peralatan & kapal', '1 sesi survei & pelatihan', 'Semua makan'],
            'en' => ['3 homestay nights', '8 guided dives', 'Gear & boat', '1 survey session & training', 'All meals'],
        ],
        'excludes' => [
            'id' => ['Penerbangan ke Wanci', 'Asuransi selam', 'Retribusi taman (dibayar di tempat)'],
            'en' => ['Flights to Wanci', 'Dive insurance', 'Park retribution (paid locally)'],
        ],
        'impact' => [
            'id' => 'Data survei menjadi milik desa adat untuk negosiasi zonasi; penyelam lokal dibayar sebagai ilmuwan warga.',
            'en' => 'Survey data belongs to the customary villages for zoning advocacy; local divers are paid as citizen scientists.',
        ],
    ],
];
