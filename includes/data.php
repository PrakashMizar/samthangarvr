<?php
// includes/data.php - Central data for mechanical parts

$parts = [
    "disk-brake" => [
        "id" => "disk-brake",
        "name" => "Ventilated Disk Brake",
        "description" => "High-performance ventilated disk brake assembly featuring a multi-piston caliper and slotted rotor.",
        "model" => "assets/models/diskbrake.glb",
        "thumb" => "assets/thumbs/dbrake.png",
        "marker" => "assets/markers/hiro.patt",
        "marker_scale" => "1.5 1.5 1.5",
        "specs" => [
            "Type" => "Ventilated Slotted",
            "Material" => "Cast Iron / Ceramic",
            "Diameter" => "320mm",
            "Complexity" => "Medium"
        ],
        "hotspots" => [
            ["slot" => "hotspot-rotor", "position" => "-0.06700354275639678m 0.016182865247081898m 0.006916788252674632m", "normal" => "0m -1.3435883843274957e-7m 0.999999999999991m", "text" => "Slotted Disc Rotor"],
            ["slot" => "hotspot-caliper", "position" => "0.08782523408327378m 0.01772180426348317m 0.017772390079519865m", "normal" => "0.9942196416290361m 0.10736528395636473m 1.4425474835488838e-8m", "text" => "Caliper Assembly"]
        ]
        ],

    "alto-k10b" => [
        "id" => "alto-k10b",
        "name" => "Alto K10B Engine",
        "description" => "3-Cylinder 1.0L K-Series engine, known for its fuel efficiency and lightweight design. Standard in Maruti Suzuki Alto K10.",
        "model" => "assets/models/altok10b.glb",
        "thumb" => "assets/thumbs/ttisthumb.png",
        "marker" => "assets/markers/hiro.patt",
        "marker_scale" => "0.05 0.05 0.05",
        "specs" => [
            "Type" => "3-Cyl SOHC",
            "Displacement" => "998cc",
            "Max Power" => "67 hp @ 6000 rpm",
            "Max Torque" => "90 Nm @ 3500 rpm",
            "Complexity" => "Low"
        ],
        "hotspots" => [
            ["slot" => "hotspot-head", "position" => "0m 0.8m 0m", "normal" => "0m 1m 0m", "text" => "Cylinder Head Assembly"],
            ["slot" => "hotspot-alternator", "position" => "0.4m 0.4m 0.2m", "normal" => "1m 0m 0m", "text" => "Alternator Unit"],
            ["slot" => "hotspot-custom-1", "position" => "1.898379955269349m -0.5547426212014583m -1.0375943483976415m", "normal" => "1m 0m 2.775557561562892e-17m", "text" => "Engine Mounting Point"]
        ]
    ],
    "fire-ext" => [
        "id" => "fire-ext",
        "name" => "Fire Extinguisher",
        "description" => "Dry Chemical Powder (DCP) Fire Extinguisher for industrial safety training. Learn the PASS technique.",
        "model" => "assets/models/fireextinguisher.glb",
        "thumb" => "assets/thumbs/fireext.png",
        "marker" => "assets/markers/hiro.patt",
        "marker_scale" => "0.1 0.1 0.1",
        "specs" => [
            "Type" => "ABC Powder",
            "Capacity" => "6kg",
            "Pressure" => "15 Bar",
            "Complexity" => "Low"
        ],
        "hotspots" => [
            ["slot" => "hotspot-hose", "position" => "17.100416124124408m 10.818651729715498m 0.5012966429818344m", "normal" => "0.7655038313007266m 0.2593337914790306m 0.5888547094666217m", "text" => "Discharge Hose (PASS: Aim)"],
            ["slot" => "hotspot-pin", "position" => "-2.7574419555062484m 22.796635670359024m 0.5830326532690774m", "normal" => "-0.8221178502731838m 0.43425664177179474m 0.36816220520211185m", "text" => "Safety Pin (PASS: Pull)"],
            ["slot" => "hotspot-cylinder", "position" => "-13.083155130095717m -6.525249432943792m 1.3731713882941246m", "normal" => "-0.9618253960751136m 0.011656201604261921m 0.27341550875747994m", "text" => "Pressure Cylinder"]
        ]
    ],
    "nissan-leaf" => [
        "id" => "nissan-leaf",
        "name" => "Nissan Leaf EV",
        "description" => "A compact five-door hatchback battery electric vehicle (BEV) manufactured by Nissan, perfect for urban eco-friendly transport.",
        "model" => "assets/models/nissanleafev.glb",
        "thumb" => "assets/thumbs/nissanleaf.png",
        "marker" => "assets/markers/hiro.patt",
        "marker_scale" => "0.1 0.1 0.1",
        "specs" => [
            "Type" => "Electric Vehicle",
            "Battery" => "40 kWh",
            "Range" => "270 km",
            "Complexity" => "High"
        ],
        "hotspots" => []
    ]
];
?>
