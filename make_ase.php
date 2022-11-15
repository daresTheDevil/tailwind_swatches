<?php
    /**
    * Make an Adobe Swatch Exchange file
    *
    * @param    array
    * @return   string
    */
    function mkASE($palettes) {
        // $internal_encoding = mb_internal_encoding();
        // mb_internal_encoding("UTF-8");

        ob_start();

        $totalColors = $numPalettes = 0;

        foreach ($palettes as $palette) {
            $totalColors += count($palette["colors"]);
            ++$numPalettes;
        }

        echo "ASEF"; # File signature
        echo pack("n*",1,0); # Version
        echo pack("N",$totalColors + ($numPalettes * 2)); # Total number of blocks

        foreach ($palettes as $palette) {
            echo pack("n",0xC001); # Group start

            # Length of this block - see below

            $title  = (mb_convert_encoding($palette["title"],"UTF-16BE","UTF-8") . pack("n",0));
            $buffer = pack("n",(strlen($title) / 2)); # Length of the group title
            $buffer .= $title; # Group title

            echo pack("N",strlen($buffer)); # Length of this block
            echo $buffer;

            foreach ($palette["colors"] as $color) {
                echo pack("n",1); # Color entry

                # Length of this block - see below

                $title  = (mb_convert_encoding($color[1],"UTF-16BE","UTF-8") . pack("n",0));
                $buffer = pack("n",(strlen($title) / 2)); # Length of the title
                $buffer .= $title; # Title

                # Colors
                list ($r,$g,$b) = array_map("intval",sscanf($color[0],"%2x%2x%2x"));
                $r /= 255;
                $g /= 255;
                $b /= 255;

                $buffer .= "RGB ";
                $buffer .= strrev(pack("f",$r));
                $buffer .= strrev(pack("f",$g));
                $buffer .= strrev(pack("f",$b));
                $buffer .= pack("n",0); # Color type - 0x00 "Global"

                echo pack("N",strlen($buffer)); # Length of this block
                echo $buffer;
            }
            echo pack("n",0xC002); # Group end

            echo pack("N",0); # Length of "Group end" block, which is 0
        }

        $return = ob_get_contents();
        ob_end_clean();

        mb_internal_encoding($internal_encoding);

        return $return;
    }

    $palettes = array (
        array(
            "title"     => "Tailwind 3.1",
            "colors"    => array (
                array ("fff", "white"),
                array ("000", "black"),
                array ("f8fafc", "slate-50"),
                array ("f1f5f9", "slate-100"),
                array ("e2e8f0", "slate-200"),
                array ("cbd5e1", "slate-300"),
                array ("94a3b8", "slate-400"),
                array ("64748b", "slate-500"),
                array ("475569", "slate-600"),
                array ("334155", "slate-700"),
                array ("1e293b", "slate-800"),
                array ("0f172a", "slate-900"),
                array ("f9fafb", "gray-50"),
                array ("f3f4f6", "gray-100"),
                array ("e5e7eb", "gray-200"),
                array ("d1d5db", "gray-300"),
                array ("9ca3af", "gray-400"),
                array ("6b7280", "gray-500"),
                array ("4b5563", "gray-600"),
                array ("374151", "gray-700"),
                array ("1f2937", "gray-800"),
                array ("111827", "gray-900"),
                array ("fafafa", "zinc-50"),
                array ("f4f4f5", "zinc-100"),
                array ("e4e4e7", "zinc-200"),
                array ("d4d4d8", "zinc-300"),
                array ("a1a1aa", "zinc-400"),
                array ("71717a", "zinc-500"),
                array ("52525b", "zinc-600"),
                array ("3f3f46", "zinc-700"),
                array ("27272a", "zinc-800"),
                array ("18181b", "zinc-900"),
                array ("fafafa", "neutral-50"),
                array ("f5f5f5", "neutral-100"),
                array ("e5e5e5", "neutral-200"),
                array ("d4d4d4", "neutral-300"),
                array ("a3a3a3", "neutral-400"),
                array ("737373", "neutral-500"),
                array ("525252", "neutral-600"),
                array ("404040", "neutral-700"),
                array ("262626", "neutral-800"),
                array ("171717", "neutral-900"),
                array ("fafaf9", "stone-50"),
                array ("f5f5f4", "stone-100"),
                array ("e7e5e4", "stone-200"),
                array ("d6d3d1", "stone-300"),
                array ("a8a29e", "stone-400"),
                array ("78716c", "stone-500"),
                array ("57534e", "stone-600"),
                array ("44403c", "stone-700"),
                array ("292524", "stone-800"),
                array ("1c1917", "stone-900"),
                array ("fef2f2", "red-50"),
                array ("fee2e2", "red-100"),
                array ("fecaca", "red-200"),
                array ("fca5a5", "red-300"),
                array ("f87171", "red-400"),
                array ("ef4444", "red-500"),
                array ("dc2626", "red-600"),
                array ("b91c1c", "red-700"),
                array ("991b1b", "red-800"),
                array ("7f1d1d", "red-900"),
                array ("fff7ed", "orange-50"),
                array ("ffedd5", "orange-100"),
                array ("fed7aa", "orange-200"),
                array ("fdba74", "orange-300"),
                array ("fb923c", "orange-400"),
                array ("f97316", "orange-500"),
                array ("ea580c", "orange-600"),
                array ("c2410c", "orange-700"),
                array ("9a3412", "orange-800"),
                array ("7c2d12", "orange-900"),
                array ("fffbeb", "amber-50"),
                array ("fef3c7", "amber-100"),
                array ("fde68a", "amber-200"),
                array ("fcd34d", "amber-300"),
                array ("fbbf24", "amber-400"),
                array ("f59e0b", "amber-500"),
                array ("d97706", "amber-600"),
                array ("b45309", "amber-700"),
                array ("92400e", "amber-800"),
                array ("78350f", "amber-900"),
                array ("fefce8", "yellow-50"),
                array ("fef9c3", "yellow-100"),
                array ("fef08a", "yellow-200"),
                array ("fde047", "yellow-300"),
                array ("facc15", "yellow-400"),
                array ("eab308", "yellow-500"),
                array ("ca8a04", "yellow-600"),
                array ("a16207", "yellow-700"),
                array ("854d0e", "yellow-800"),
                array ("713f12", "yellow-900"),
                array ("f7fee7", "lime-50"),
                array ("ecfccb", "lime-100"),
                array ("d9f99d", "lime-200"),
                array ("bef264", "lime-300"),
                array ("a3e635", "lime-400"),
                array ("84cc16", "lime-500"),
                array ("65a30d", "lime-600"),
                array ("4d7c0f", "lime-700"),
                array ("3f6212", "lime-800"),
                array ("365314", "lime-900"),
                array ("f0fdf4", "green-50"),
                array ("dcfce7", "green-100"),
                array ("bbf7d0", "green-200"),
                array ("86efac", "green-300"),
                array ("4ade80", "green-400"),
                array ("22c55e", "green-500"),
                array ("16a34a", "green-600"),
                array ("15803d", "green-700"),
                array ("166534", "green-800"),
                array ("14532d", "green-900"),
                array ("ecfdf5", "emerald-50"),
                array ("d1fae5", "emerald-100"),
                array ("a7f3d0", "emerald-200"),
                array ("6ee7b7", "emerald-300"),
                array ("34d399", "emerald-400"),
                array ("10b981", "emerald-500"),
                array ("059669", "emerald-600"),
                array ("047857", "emerald-700"),
                array ("065f46", "emerald-800"),
                array ("064e3b", "emerald-900"),
                array ("f0fdfa", "teal-50"),
                array ("ccfbf1", "teal-100"),
                array ("99f6e4", "teal-200"),
                array ("5eead4", "teal-300"),
                array ("2dd4bf", "teal-400"),
                array ("14b8a6", "teal-500"),
                array ("0d9488", "teal-600"),
                array ("0f766e", "teal-700"),
                array ("115e59", "teal-800"),
                array ("134e4a", "teal-900"),
                array ("ecfeff", "cyan-50"),
                array ("cffafe", "cyan-100"),
                array ("a5f3fc", "cyan-200"),
                array ("67e8f9", "cyan-300"),
                array ("22d3ee", "cyan-400"),
                array ("06b6d4", "cyan-500"),
                array ("0891b2", "cyan-600"),
                array ("0e7490", "cyan-700"),
                array ("155e75", "cyan-800"),
                array ("164e63", "cyan-900"),
                array ("f0f9ff", "sky-50"),
                array ("e0f2fe", "sky-100"),
                array ("bae6fd", "sky-200"),
                array ("7dd3fc", "sky-300"),
                array ("38bdf8", "sky-400"),
                array ("0ea5e9", "sky-500"),
                array ("0284c7", "sky-600"),
                array ("0369a1", "sky-700"),
                array ("075985", "sky-800"),
                array ("0c4a6e", "sky-900"),
                array ("eff6ff", "blue-50"),
                array ("dbeafe", "blue-100"),
                array ("bfdbfe", "blue-200"),
                array ("93c5fd", "blue-300"),
                array ("60a5fa", "blue-400"),
                array ("3b82f6", "blue-500"),
                array ("2563eb", "blue-600"),
                array ("1d4ed8", "blue-700"),
                array ("1e40af", "blue-800"),
                array ("1e3a8a", "blue-900"),
                array ("eef2ff", "indigo-50"),
                array ("e0e7ff", "indigo-100"),
                array ("c7d2fe", "indigo-200"),
                array ("a5b4fc", "indigo-300"),
                array ("818cf8", "indigo-400"),
                array ("6366f1", "indigo-500"),
                array ("4f46e5", "indigo-600"),
                array ("4338ca", "indigo-700"),
                array ("3730a3", "indigo-800"),
                array ("312e81", "indigo-900"),
                array ("f5f3ff", "violet-50"),
                array ("ede9fe", "violet-100"),
                array ("ddd6fe", "violet-200"),
                array ("c4b5fd", "violet-300"),
                array ("a78bfa", "violet-400"),
                array ("8b5cf6", "violet-500"),
                array ("7c3aed", "violet-600"),
                array ("6d28d9", "violet-700"),
                array ("5b21b6", "violet-800"),
                array ("4c1d95", "violet-900"),
                array ("faf5ff", "purple-50"),
                array ("f3e8ff", "purple-100"),
                array ("e9d5ff", "purple-200"),
                array ("d8b4fe", "purple-300"),
                array ("c084fc", "purple-400"),
                array ("a855f7", "purple-500"),
                array ("9333ea", "purple-600"),
                array ("7e22ce", "purple-700"),
                array ("6b21a8", "purple-800"),
                array ("581c87", "purple-900"),
                array("fdf4ff", "fuchsia-50"),
                array("fae8ff", "fuchsia-100"),
                array("f5d0fe", "fuchsia-200"),
                array("f0abfc", "fuchsia-300"),
                array("e879f9", "fuchsia-400"),
                array("d946ef", "fuchsia-500"),
                array("c026d3", "fuchsia-600"),
                array("a21caf", "fuchsia-700"),
                array("86198f", "fuchsia-800"),
                array("701a75", "fuchsia-900"),
                array("fdf2f8", "pink-50"),
                array("fce7f3", "pink-100"),
                array("fbcfe8", "pink-200"),
                array("f9a8d4", "pink-300"),
                array("f472b6", "pink-400"),
                array("ec4899", "pink-500"),
                array("db2777", "pink-600"),
                array("be185d", "pink-700"),
                array("9d174d", "pink-800"),
                array("831843", "pink-900"),
                array("fff1f2", "rose-50"),
                array("ffe4e6", "rose-100"),
                array("fecdd3", "rose-200"),
                array("fda4af", "rose-300"),
                array("fb7185", "rose-400"),
                array("f43f5e", "rose-500"),
                array("e11d48", "rose-600"),
                array("be123c", "rose-700"),
                array("9f1239", "rose-800"),
                array("881337", "rose-900"),
            )
        )
    );

    $ase = mkASE($palettes);
