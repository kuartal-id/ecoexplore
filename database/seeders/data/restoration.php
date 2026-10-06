<?php

// SAMPLE restoration projects for the MVP. Partners, unit prices and targets are
// placeholders until verified with real partners. funded_units starts at 0 and only grows
// through paid bookings (BookingPayments::markPaid) -- no invented progress.

return [
    [
        'slug' => 'gili-reef-frame-restoration', 'type' => 'coral', 'sort_order' => 10,
        'location' => 'Gili Islands, North Lombok', 'partner' => 'Local reef-restoration group (sample)',
        'unit_price_idr' => 750000, 'target_units' => 200, 'image' => 'assets/img/coral.svg',
        'title' => ['id' => 'Restorasi Rangka Terumbu Gili', 'en' => 'Gili Reef Frame Restoration'],
        'unit_label' => ['id' => 'rangka terumbu', 'en' => 'reef frame'],
        'summary' => [
            'id' => 'Danai satu rangka baja berlapis tempat fragmen karang ditanam dan dirawat oleh penyelam lokal.',
            'en' => 'Fund one coated steel frame where coral fragments are planted and maintained by local divers.',
        ],
        'description' => [
            'id' => 'Setiap rangka ditempatkan di area terumbu rusak, ditanami fragmen karang dari koloni sehat, dan dibersihkan secara rutin. Pendana menerima pembaruan berkala (foto dan catatan pemantauan) setelah program berjalan.',
            'en' => 'Each frame is placed on a damaged reef patch, planted with fragments from healthy colonies and cleaned regularly. Funders receive periodic updates (photos and monitoring notes) once the programme is running.',
        ],
    ],
    [
        'slug' => 'adopt-a-coral-fragment', 'type' => 'coral', 'sort_order' => 20,
        'location' => 'Gili Air, North Lombok', 'partner' => 'Local dive centre nursery (sample)',
        'unit_price_idr' => 150000, 'target_units' => 1000, 'image' => 'assets/img/reef.svg',
        'title' => ['id' => 'Adopsi Fragmen Karang', 'en' => 'Adopt a Coral Fragment'],
        'unit_label' => ['id' => 'fragmen karang', 'en' => 'coral fragment'],
        'summary' => [
            'id' => 'Adopsi satu fragmen karang di pembibitan dan ikuti pertumbuhannya.',
            'en' => 'Adopt one coral fragment in the nursery and follow its growth.',
        ],
        'description' => [
            'id' => 'Fragmen dirawat di pembibitan bawah air sebelum dipindahkan ke rangka terumbu. Cocok sebagai hadiah atau aktivitas keluarga.',
            'en' => 'Fragments are grown in an underwater nursery before moving to the reef frames. A good gift or family activity.',
        ],
    ],
    [
        'slug' => 'east-lombok-mangrove-planting', 'type' => 'mangrove', 'sort_order' => 30,
        'location' => 'East Lombok coast', 'partner' => 'Coastal community group (sample)',
        'unit_price_idr' => 100000, 'target_units' => 1500, 'image' => 'assets/img/mangrove.svg',
        'title' => ['id' => 'Penanaman Mangrove Lombok Timur', 'en' => 'East Lombok Mangrove Planting'],
        'unit_label' => ['id' => '10 bibit mangrove', 'en' => '10 mangrove seedlings'],
        'summary' => [
            'id' => 'Sepuluh bibit mangrove ditanam dan disulam oleh kelompok pesisir, melindungi pantai dan tempat ikan bertelur.',
            'en' => 'Ten mangrove seedlings planted and replaced where needed by a coastal group, protecting the shore and fish nurseries.',
        ],
        'description' => [
            'id' => 'Bibit berasal dari pembibitan desa. Biaya mencakup bibit, penanaman, dan penyulaman bibit yang mati pada tahun pertama.',
            'en' => 'Seedlings come from a village nursery. The price covers seedlings, planting and replacing seedlings that die in the first year.',
        ],
    ],
    [
        'slug' => 'sekotong-mangrove-nursery', 'type' => 'mangrove', 'sort_order' => 40,
        'location' => 'Sekotong, West Lombok', 'partner' => 'Women-led nursery cooperative (sample)',
        'unit_price_idr' => 250000, 'target_units' => 300, 'image' => 'assets/img/mangrove.svg',
        'title' => ['id' => 'Pembibitan Mangrove Sekotong', 'en' => 'Sekotong Mangrove Nursery'],
        'unit_label' => ['id' => 'paket pembibitan', 'en' => 'nursery bundle'],
        'summary' => [
            'id' => 'Dukung pembibitan mangrove yang dikelola perempuan pesisir: polybag, benih, dan upah perawatan.',
            'en' => 'Support a mangrove nursery run by coastal women: polybags, propagules and care wages.',
        ],
        'description' => [
            'id' => 'Satu paket membiayai sekitar satu minggu kerja pembibitan. Bibit digunakan untuk penanaman di pesisir sekitar.',
            'en' => 'One bundle funds roughly a week of nursery work. Seedlings are used for planting along the nearby coast.',
        ],
    ],
    [
        'slug' => 'rinjani-watershed-trees', 'type' => 'forest', 'sort_order' => 50,
        'location' => 'Rinjani foothills, North & Central Lombok', 'partner' => 'Village forest farmers group (sample)',
        'unit_price_idr' => 75000, 'target_units' => 2000, 'image' => 'assets/img/forest.svg',
        'title' => ['id' => 'Pohon untuk DAS Rinjani', 'en' => 'Rinjani Watershed Trees'],
        'unit_label' => ['id' => 'pohon (3 tahun perawatan)', 'en' => 'tree (3 years of care)'],
        'summary' => [
            'id' => 'Tanam satu pohon asli atau pohon serbaguna dengan perawatan tiga tahun untuk menjaga mata air di lereng Rinjani.',
            'en' => 'Plant one native or multi-purpose tree with three years of care to protect springs on Rinjani\'s slopes.',
        ],
        'description' => [
            'id' => 'Petani hutan desa menanam dan merawat pohon di lahan kritis daerah aliran sungai. Jenis pohon dipilih bersama warga.',
            'en' => 'Village forest farmers plant and look after trees on degraded watershed land. Species are chosen with the community.',
        ],
    ],
    [
        'slug' => 'aik-berik-spring-agroforestry', 'type' => 'forest', 'sort_order' => 60,
        'location' => 'Aik Berik, Central Lombok', 'partner' => 'Aik Berik farmers group (sample)',
        'unit_price_idr' => 50000, 'target_units' => 1500, 'image' => 'assets/img/waterfall.svg',
        'title' => ['id' => 'Agroforestri Mata Air Aik Berik', 'en' => 'Aik Berik Spring Agroforestry'],
        'unit_label' => ['id' => 'bibit agroforestri', 'en' => 'agroforestry seedling'],
        'summary' => [
            'id' => 'Bibit kopi, durian, atau pohon peneduh untuk kebun campur di sekitar mata air Aik Berik.',
            'en' => 'Coffee, durian or shade-tree seedlings for mixed gardens around the Aik Berik springs.',
        ],
        'description' => [
            'id' => 'Kebun campur menahan tanah dan air sekaligus memberi penghasilan bagi petani. Bibit dibagikan dan dipantau oleh kelompok tani.',
            'en' => 'Mixed gardens hold soil and water while giving farmers an income. Seedlings are distributed and monitored by the farmers\' group.',
        ],
    ],
];
