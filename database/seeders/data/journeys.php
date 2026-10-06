<?php

// SAMPLE CONTENT for the MVP. Descriptions, itineraries, inclusions and prices are
// realistic placeholders written for launch preparation; Ecoexplore must confirm every
// detail (partners, timings, park fees, prices) before selling. Prices: IDR per person.

return [
    [
        'slug' => 'gili-dive-reef-guardians',
        'category' => 'dive',
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
        'category' => 'dive',
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
        'category' => 'trek',
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
        'category' => 'trek',
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
        'category' => 'highland',
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
        'category' => 'geotour',
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
        'category' => 'food',
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
        'category' => 'culture',
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
        'category' => 'geotour',
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
];
