<?php

/*
| Site-wide content for the WasteBack platform. Contact details below are
| placeholders for the project demo: replace them before going live.
*/

return [
    'name' => env('APP_NAME', 'WasteBack'),
    'tagline' => 'Digital waste buyback for Kampala',
    'phone' => '+256 700 000 111',
    'phone_link' => '+256700000111',
    'whatsapp' => '256700000111',
    'email' => 'hello@wasteback.ug',
    'address' => 'Banda Stage, Kampala Jinja Road, Kampala',
    'hours' => 'Monday to Saturday, 8:00 to 18:00',
    'experience_years' => 5,

    'zones' => [
        'Banda', 'Kyambogo', 'Kireka', 'Nakawa', 'Ntinda', 'Kiwatule',
        'Bweyogerere', 'Kasokoso', 'Namboole', 'Kazinga', 'Mbuya', 'Nsambya',
    ],

    'team' => [
        ['name' => 'Nakigudde Margret', 'role' => 'Project Lead'],
        ['name' => 'Mirembe Allen', 'role' => 'Systems Analyst'],
        ['name' => 'Naluwaga Jazirah', 'role' => 'Database Designer'],
        ['name' => 'Nampala Tunisha Ivy', 'role' => 'Interface Designer'],
        ['name' => 'Opio Emmanuel', 'role' => 'Backend Developer'],
    ],

    /*
    | Every picture is stored in public/images/<key>.jpg (1600px wide) with a
    | 400px copy in public/images/thumbs. The ids are the Unsplash originals
    | they were downloaded from. The helper img() returns the local file.
    */
    'images' => [
        'hero' => 'photo-1620609997104-1cd7ca877232',
        'hero_card' => 'photo-1715065590103-0eb717ace022',
        'dump' => 'photo-1666804855649-77057e76281c',
        'dump_walker' => 'photo-1685217623232-baea8f8fcc07',
        'drain' => 'photo-1753818293918-d4de94349ac7',
        'channel' => 'photo-1673203300654-d973e8944910',
        'bottles' => 'photo-1595278069441-2cf29f8005a4',
        'bottles_bag' => 'photo-1715065590103-0eb717ace022',
        'bottles_pile' => 'photo-1710189605149-6cb6b81e5e9e',
        'bottles_cage' => 'photo-1653406384710-08688ec6b979',
        'containers' => 'photo-1670159269165-0482a6fc38b9',
        'loading' => 'photo-1625191824707-31f8bd5862d0',
        'truck_dump' => 'photo-1773852184074-e7ecb1dd3665',
        'paper_bales' => 'photo-1781243680823-aae6c7f1ff12',
        'cardboard' => 'photo-1507560461415-997cd00bfd45',
        'plastic_bales' => 'photo-1721622248626-e7b5c29de4b2',
        'scrap_metal' => 'photo-1785900976828-9d67c8b24134',
        'metal_parts' => 'photo-1723365316514-8509dea457f2',
        'excavator' => 'photo-1722695694560-f452b0919d3a',
        'glass' => 'photo-1706468808996-1c9841911d57',
        'ewaste' => 'photo-1745501232519-ae3f8739bea4',
        'conveyor' => 'photo-1763315156830-07870b159121',
        'kampala' => 'photo-1675756261486-09bd1e0f6c8a',
        'agent_vest' => 'photo-1673825128658-1aec6df5d5c9',
        'boda' => 'photo-1667844141292-0754524d5897',
        'litter_pick' => 'photo-1662610828810-f02ddd664b16',
        'bin_woman' => 'photo-1643701323325-87c79c0e62a3',
        'phone_woman' => 'photo-1680878903102-92692799ef36',
        'phone_woman2' => 'photo-1677935711525-1059c0cb9b44',
        'phone_man' => 'photo-1622556498246-755f44ca76f3',
        'phone_hands' => 'photo-1624207616837-6d115cef5276',
        'vendor' => 'photo-1687422808248-f807f4ea2a2e',
        'market_woman' => 'photo-1675345555585-e3448d825b12',
        'business_man' => 'photo-1758519291531-e96279895745',
        'team_meeting' => 'photo-1655720357872-ce227e4164ba',
        'team_1' => 'photo-1573496528388-2c5e0088d40f',
        'team_2' => 'photo-1757140448921-f120d58546dc',
        'team_3' => 'photo-1614023342667-6f060e9d1e04',
        'team_4' => 'photo-1561878777-d054330928e3',
        'team_5' => 'photo-1751374858042-b8b9ff8480aa',
    ],
];
