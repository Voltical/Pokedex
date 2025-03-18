-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2025 at 05:22 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pokedex`
--

-- --------------------------------------------------------

--
-- Table structure for table `pokemons`
--

CREATE TABLE `pokemons` (
  `id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pokemons`
--

INSERT INTO `pokemons` (`id`, `number`, `name`, `type`, `image_url`, `description`) VALUES
(205, 1, 'Bulbasaur', 'gras,poison', './assets/bulbasaur.png', 'Placeholder'),
(206, 2, 'Ivysaur', 'gras,poison', './assets/ivysaur.png', 'Placeholder'),
(207, 3, 'Venusaur', 'gras,poison', './assets/venusaur.png', 'Placeholder'),
(208, 4, 'Charmander', 'vuur', './assets/charmander.png', 'Placeholder'),
(209, 5, 'Charmeleon', 'vuur', './assets/charmeleon.png', 'Placeholder'),
(210, 6, 'Charizard', 'vuur,vliegend', './assets/charizard.png', 'Placeholder'),
(211, 7, 'Squirtle', 'water', './assets/squirtle.png', 'Placeholder'),
(212, 8, 'Wartortle', 'water', './assets/wartortle.png', 'Placeholder'),
(213, 9, 'Blastoise', 'water', './assets/blastoise.png', 'Placeholder'),
(214, 10, 'Caterpie', 'bug', './assets/caterpie.png', 'Placeholder'),
(215, 11, 'Metapod', 'bug', './assets/metapod.png', 'Placeholder'),
(216, 12, 'Butterfree', 'bug,vliegend', './assets/butterfree.png', 'Placeholder'),
(217, 13, 'Weedle', 'bug,poison', './assets/weedle.png', 'Placeholder'),
(218, 14, 'Kakuna', 'bug,poison', './assets/kakuna.png', 'Placeholder'),
(219, 15, 'Beedrill', 'bug,poison', './assets/beedrill.png', 'Placeholder'),
(220, 16, 'Pidgey', 'normaal,vliegend', './assets/pidgey.png', 'Placeholder'),
(221, 17, 'Pidgeotto', 'normaal,vliegend', './assets/pidgeotto.png', 'Placeholder'),
(222, 18, 'Pidgeot', 'normaal,vliegend', './assets/pidgeot.png', 'Placeholder'),
(223, 19, 'Rattata', 'normaal', './assets/rattata.png', 'Placeholder'),
(224, 20, 'Raticate', 'normaal', './assets/raticate.png', 'Placeholder'),
(225, 21, 'Spearow', 'normaal,vliegend', './assets/spearow.png', 'Placeholder'),
(226, 22, 'Fearow', 'normaal,vliegend', './assets/fearow.png', 'Placeholder'),
(227, 23, 'Ekans', 'poison', './assets/ekans.png', 'Placeholder'),
(228, 24, 'Arbok', 'poison', './assets/arbok.png', 'Placeholder'),
(229, 25, 'Pikachu', 'elektro', './assets/pikachu.png', 'Placeholder'),
(230, 26, 'Raichu', 'elektro', './assets/raichu.png', 'Placeholder'),
(231, 27, 'Sandshrew', 'ground', './assets/sandshrew.png', 'Placeholder'),
(232, 28, 'Sandslash', 'ground', './assets/sandslash.png', 'Placeholder'),
(233, 29, 'Nidoran♀', 'poison', './assets/nidoran-f.png', 'Placeholder'),
(234, 30, 'Nidorina', 'poison', './assets/nidorina.png', 'Placeholder'),
(235, 31, 'Nidoqueen', 'poison,ground', './assets/nidoqueen.png', 'Placeholder'),
(236, 32, 'Nidoran♂', 'poison', './assets/nidoran-m.png', 'Placeholder'),
(237, 33, 'Nidorino', 'poison', './assets/nidorino.png', 'Placeholder'),
(238, 34, 'Nidoking', 'poison,ground', './assets/nidoking.png', 'Placeholder'),
(239, 35, 'Clefairy', 'fairy', './assets/clefairy.png', 'Placeholder'),
(240, 36, 'Clefable', 'fairy', './assets/clefable.png', 'Placeholder'),
(241, 37, 'Vulpix', 'vuur', './assets/vulpix.png', 'Placeholder'),
(242, 38, 'Ninetales', 'vuur', './assets/ninetales.png', 'Placeholder'),
(243, 39, 'Jigglypuff', 'normaal,fairy', './assets/jigglypuff.png', 'Placeholder'),
(244, 40, 'Wigglytuff', 'normaal,fairy', './assets/wigglytuff.png', 'Placeholder'),
(245, 41, 'Zubat', 'poison,vliegend', './assets/zubat.png', 'Placeholder'),
(246, 42, 'Golbat', 'poison,vliegend', './assets/golbat.png', 'Placeholder'),
(247, 43, 'Oddish', 'gras,poison', './assets/oddish.png', 'Placeholder'),
(248, 44, 'Gloom', 'gras,poison', './assets/gloom.png', 'Placeholder'),
(249, 45, 'Vileplume', 'gras,poison', './assets/vileplume.png', 'Placeholder'),
(250, 46, 'Paras', 'bug,gras', './assets/paras.png', 'Placeholder'),
(251, 47, 'Parasect', 'bug,gras', './assets/parasect.png', 'Placeholder'),
(252, 48, 'Venonat', 'bug,poison', './assets/venonat.png', 'Placeholder'),
(253, 49, 'Venomoth', 'bug,poison', './assets/venomoth.png', 'Placeholder'),
(254, 50, 'Diglett', 'ground', './assets/diglett.png', 'Placeholder'),
(255, 51, 'Dugtrio', 'ground', './assets/dugtrio.png', 'Placeholder'),
(256, 52, 'Meowth', 'normaal', './assets/meowth.png', 'Placeholder'),
(257, 53, 'Persian', 'normaal', './assets/persian.png', 'Placeholder'),
(258, 54, 'Psyduck', 'water', './assets/psyduck.png', 'Placeholder'),
(259, 55, 'Golduck', 'water', './assets/golduck.png', 'Placeholder'),
(260, 56, 'Mankey', 'fighting', './assets/mankey.png', 'Placeholder'),
(261, 57, 'Primeape', 'fighting', './assets/primeape.png', 'Placeholder'),
(262, 58, 'Growlithe', 'vuur', './assets/growlithe.png', 'Placeholder'),
(263, 59, 'Arcanine', 'vuur', './assets/arcanine.png', 'Placeholder'),
(264, 60, 'Poliwag', 'water', './assets/poliwag.png', 'Placeholder'),
(265, 61, 'Poliwhirl', 'water', './assets/poliwhirl.png', 'Placeholder'),
(266, 62, 'Poliwrath', 'water,fighting', './assets/poliwrath.png', 'Placeholder'),
(267, 63, 'Abra', 'psychic', './assets/abra.png', 'Placeholder'),
(268, 64, 'Kadabra', 'psychic', './assets/kadabra.png', 'Placeholder'),
(269, 65, 'Alakazam', 'psychic', './assets/alakazam.png', 'Placeholder'),
(270, 66, 'Machop', 'fighting', './assets/machop.png', 'Placeholder'),
(271, 67, 'Machoke', 'fighting', './assets/machoke.png', 'Placeholder'),
(272, 68, 'Machamp', 'fighting', './assets/machamp.png', 'Placeholder'),
(273, 69, 'Bellsprout', 'gras,poison', './assets/bellsprout.png', 'Placeholder'),
(274, 70, 'Weepinbell', 'gras,poison', './assets/weepinbell.png', 'Placeholder'),
(275, 71, 'Victreebel', 'gras,poison', './assets/victreebel.png', 'Placeholder'),
(276, 72, 'Tentacool', 'water,poison', './assets/tentacool.png', 'Placeholder'),
(277, 73, 'Tentacruel', 'water,poison', './assets/tentacruel.png', 'Placeholder'),
(278, 74, 'Geodude', 'rock,ground', './assets/geodude.png', 'Placeholder'),
(279, 75, 'Graveler', 'rock,ground', './assets/graveler.png', 'Placeholder'),
(280, 76, 'Golem', 'rock,ground', './assets/golem.png', 'Placeholder'),
(281, 77, 'Ponyta', 'vuur', './assets/ponyta.png', 'Placeholder'),
(282, 78, 'Rapidash', 'vuur', './assets/rapidash.png', 'Placeholder'),
(283, 79, 'Slowpoke', 'water,psychic', './assets/slowpoke.png', 'Placeholder'),
(284, 80, 'Slowbro', 'water,psychic', './assets/slowbro.png', 'Placeholder'),
(285, 81, 'Magnemite', 'elektro,steel', './assets/magnemite.png', 'Placeholder'),
(286, 82, 'Magneton', 'elektro,steel', './assets/magneton.png', 'Placeholder'),
(287, 83, 'Farfetch''d', 'normaal,vliegend', './assets/farfetchd.png', 'Placeholder'),
(288, 84, 'Doduo', 'normaal,vliegend', './assets/doduo.png', 'Placeholder'),
(289, 85, 'Dodrio', 'normaal,vliegend', './assets/dodrio.png', 'Placeholder'),
(290, 86, 'Seel', 'water', './assets/seel.png', 'Placeholder'),
(291, 87, 'Dewgong', 'water,ijs', './assets/dewgong.png', 'Placeholder'),
(292, 88, 'Grimer', 'poison', './assets/grimer.png', 'Placeholder'),
(293, 89, 'Muk', 'poison', './assets/muk.png', 'Placeholder'),
(294, 90, 'Shellder', 'water', './assets/shellder.png', 'Placeholder'),
(295, 91, 'Cloyster', 'water,ijs', './assets/cloyster.png', 'Placeholder'),
(296, 92, 'Gastly', 'ghost,poison', './assets/gastly.png', 'Placeholder'),
(297, 93, 'Haunter', 'ghost,poison', './assets/haunter.png', 'Placeholder'),
(298, 94, 'Gengar', 'ghost,poison', './assets/gengar.png', 'Placeholder'),
(299, 95, 'Onix', 'rock,ground', './assets/onix.png', 'Placeholder'),
(300, 96, 'Drowzee', 'psychic', './assets/drowzee.png', 'Placeholder'),
(301, 97, 'Hypno', 'psychic', './assets/hypno.png', 'Placeholder'),
(302, 98, 'Krabby', 'water', './assets/krabby.png', 'Placeholder'),
(303, 99, 'Kingler', 'water', './assets/kingler.png', 'Placeholder'),
(304, 100, 'Voltorb', 'elektro', './assets/voltorb.png', 'Placeholder'),
(305, 101, 'Electrode', 'elektro', './assets/electrode.png', 'Placeholder'),
(306, 102, 'Exeggcute', 'gras,psychic', './assets/exeggcute.png', 'Placeholder'),
(307, 103, 'Exeggutor', 'gras,psychic', './assets/exeggutor.png', 'Placeholder'),
(308, 104, 'Cubone', 'ground', './assets/cubone.png', 'Placeholder'),
(309, 105, 'Marowak', 'ground', './assets/marowak.png', 'Placeholder'),
(310, 106, 'Hitmonlee', 'fighting', './assets/hitmonlee.png', 'Placeholder'),
(311, 107, 'Hitmonchan', 'fighting', './assets/hitmonchan.png', 'Placeholder'),
(312, 108, 'Lickitung', 'normaal', './assets/lickitung.png', 'Placeholder'),
(313, 109, 'Koffing', 'poison', './assets/koffing.png', 'Placeholder'),
(314, 110, 'Weezing', 'poison', './assets/weezing.png', 'Placeholder'),
(315, 111, 'Rhyhorn', 'ground,rock', './assets/rhyhorn.png', 'Placeholder'),
(316, 112, 'Rhydon', 'ground,rock', './assets/rhydon.png', 'Placeholder'),
(317, 113, 'Chansey', 'normaal', './assets/chansey.png', 'Placeholder'),
(318, 114, 'Tangela', 'gras', './assets/tangela.png', 'Placeholder'),
(319, 115, 'Kangaskhan', 'normaal', './assets/kangaskhan.png', 'Placeholder'),
(320, 116, 'Horsea', 'water', './assets/horsea.png', 'Placeholder'),
(321, 117, 'Seadra', 'water', './assets/seadra.png', 'Placeholder'),
(322, 118, 'Goldeen', 'water', './assets/goldeen.png', 'Placeholder'),
(323, 119, 'Seaking', 'water', './assets/seaking.png', 'Placeholder'),
(324, 120, 'Staryu', 'water', './assets/staryu.png', 'Placeholder'),
(325, 121, 'Starmie', 'water,psychic', './assets/starmie.png', 'Placeholder'),
(326, 122, 'Mr. Mime', 'psychic,fairy', './assets/mr-mime.png', 'Placeholder'),
(327, 123, 'Scyther', 'bug,vliegend', './assets/scyther.png', 'Placeholder'),
(328, 124, 'Jynx', 'ijs,psychic', './assets/jynx.png', 'Placeholder'),
(329, 125, 'Electabuzz', 'elektro', './assets/electabuzz.png', 'Placeholder'),
(330, 126, 'Magmar', 'vuur', './assets/magmar.png', 'Placeholder'),
(331, 127, 'Pinsir', 'bug', './assets/pinsir.png', 'Placeholder'),
(332, 128, 'Tauros', 'normaal', './assets/tauros.png', 'Placeholder'),
(333, 129, 'Magikarp', 'water', './assets/magikarp.png', 'Placeholder'),
(334, 130, 'Gyarados', 'water,vliegend', './assets/gyarados.png', 'Placeholder'),
(335, 131, 'Lapras', 'water,ijs', './assets/lapras.png', 'Placeholder'),
(336, 132, 'Ditto', 'normaal', './assets/ditto.png', 'Placeholder'),
(337, 133, 'Eevee', 'normaal', './assets/eevee.png', 'Placeholder'),
(338, 134, 'Vaporeon', 'water', './assets/vaporeon.png', 'Placeholder'),
(339, 135, 'Jolteon', 'elektro', './assets/jolteon.png', 'Placeholder'),
(340, 136, 'Flareon', 'vuur', './assets/flareon.png', 'Placeholder'),
(341, 137, 'Porygon', 'normaal', './assets/porygon.png', 'Placeholder'),
(342, 138, 'Omanyte', 'rock,water', './assets/omanyte.png', 'Placeholder'),
(343, 139, 'Omastar', 'rock,water', './assets/omastar.png', 'Placeholder'),
(344, 140, 'Kabuto', 'rock,water', './assets/kabuto.png', 'Placeholder'),
(345, 141, 'Kabutops', 'rock,water', './assets/kabutops.png', 'Placeholder'),
(346, 142, 'Aerodactyl', 'rock,vliegend', './assets/aerodactyl.png', 'Placeholder'),
(347, 143, 'Snorlax', 'normaal', './assets/snorlax.png', 'Placeholder'),
(348, 144, 'Articuno', 'ijs,vliegend', './assets/articuno.png', 'Placeholder'),
(349, 145, 'Zapdos', 'elektro,vliegend', './assets/zapdos.png', 'Placeholder'),
(350, 146, 'Moltres', 'vuur,vliegend', './assets/moltres.png', 'Placeholder'),
(351, 147, 'Dratini', 'dragon', './assets/dratini.png', 'Placeholder'),
(352, 148, 'Dragonair', 'dragon', './assets/dragonair.png', 'Placeholder'),
(353, 149, 'Dragonite', 'dragon,vliegend', './assets/dragonite.png', 'Placeholder'),
(354, 150, 'Mewtwo', 'psychic', './assets/mewtwo.png', 'Placeholder'),
(355, 151, 'Mew', 'psychic', './assets/mew.png', 'Placeholder'),
(356, 152, 'Chikorita', 'gras', './assets/chikorita.png', 'Placeholder'),
(357, 153, 'Bayleef', 'gras', './assets/bayleef.png', 'Placeholder'),
(358, 154, 'Meganium', 'gras', './assets/meganium.png', 'Placeholder'),
(359, 155, 'Cyndaquil', 'vuur', './assets/cyndaquil.png', 'Placeholder'),
(360, 156, 'Quilava', 'vuur', './assets/quilava.png', 'Placeholder'),
(361, 157, 'Typhlosion', 'vuur', './assets/typhlosion.png', 'Placeholder'),
(362, 158, 'Totodile', 'water', './assets/totodile.png', 'Placeholder'),
(363, 159, 'Croconaw', 'water', './assets/croconaw.png', 'Placeholder'),
(364, 160, 'Feraligatr', 'water', './assets/feraligatr.png', 'Placeholder'),
(365, 161, 'Sentret', 'normaal', './assets/sentret.png', 'Placeholder'),
(366, 162, 'Furret', 'normaal', './assets/furret.png', 'Placeholder'),
(367, 163, 'Hoothoot', 'normaal,vliegend', './assets/hoothoot.png', 'Placeholder'),
(368, 164, 'Noctowl', 'normaal,vliegend', './assets/noctowl.png', 'Placeholder'),
(369, 165, 'Ledyba', 'bug,vliegend', './assets/ledyba.png', 'Placeholder'),
(370, 166, 'Ledian', 'bug,vliegend', './assets/ledian.png', 'Placeholder'),
(371, 167, 'Spinarak', 'bug,poison', './assets/spinarak.png', 'Placeholder'),
(372, 168, 'Ariados', 'bug,poison', './assets/ariados.png', 'Placeholder'),
(373, 169, 'Crobat', 'poison,vliegend', './assets/crobat.png', 'Placeholder'),
(374, 170, 'Chinchou', 'water,elektro', './assets/chinchou.png', 'Placeholder'),
(375, 171, 'Lanturn', 'water,elektro', './assets/lanturn.png', 'Placeholder'),
(376, 172, 'Pichu', 'elektro', './assets/pichu.png', 'Placeholder'),
(377, 173, 'Cleffa', 'fairy', './assets/cleffa.png', 'Placeholder'),
(378, 174, 'Igglybuff', 'normaal,fairy', './assets/igglybuff.png', 'Placeholder'),
(379, 175, 'Togepi', 'fairy', './assets/togepi.png', 'Placeholder'),
(380, 176, 'Togetic', 'fairy,vliegend', './assets/togetic.png', 'Placeholder'),
(381, 177, 'Natu', 'psychic,vliegend', './assets/natu.png', 'Placeholder'),
(382, 178, 'Xatu', 'psychic,vliegend', './assets/xatu.png', 'Placeholder'),
(383, 179, 'Mareep', 'elektro', './assets/mareep.png', 'Placeholder'),
(384, 180, 'Flaaffy', 'elektro', './assets/flaaffy.png', 'Placeholder'),
(385, 181, 'Ampharos', 'elektro', './assets/ampharos.png', 'Placeholder'),
(386, 182, 'Bellossom', 'gras', './assets/bellossom.png', 'Placeholder'),
(387, 183, 'Marill', 'water,fairy', './assets/marill.png', 'Placeholder'),
(388, 184, 'Azumarill', 'water,fairy', './assets/azumarill.png', 'Placeholder'),
(389, 185, 'Sudowoodo', 'rock', './assets/sudowoodo.png', 'Placeholder'),
(390, 186, 'Politoed', 'water', './assets/politoed.png', 'Placeholder'),
(391, 187, 'Hoppip', 'gras,vliegend', './assets/hoppip.png', 'Placeholder'),
(392, 188, 'Skiploom', 'gras,vliegend', './assets/skiploom.png', 'Placeholder'),
(393, 189, 'Jumpluff', 'gras,vliegend', './assets/jumpluff.png', 'Placeholder'),
(394, 190, 'Aipom', 'normaal', './assets/aipom.png', 'Placeholder'),
(395, 191, 'Sunkern', 'gras', './assets/sunkern.png', 'Placeholder'),
(396, 192, 'Sunflora', 'gras', './assets/sunflora.png', 'Placeholder'),
(397, 193, 'Yanma', 'bug,vliegend', './assets/yanma.png', 'Placeholder'),
(398, 194, 'Wooper', 'water,ground', './assets/wooper.png', 'Placeholder'),
(399, 195, 'Quagsire', 'water,ground', './assets/quagsire.png', 'Placeholder'),
(400, 196, 'Espeon', 'psychic', './assets/espeon.png', 'Placeholder'),
(401, 197, 'Umbreon', 'dark', './assets/umbreon.png', 'Placeholder'),
(402, 198, 'Murkrow', 'dark,vliegend', './assets/murkrow.png', 'Placeholder'),
(403, 199, 'Slowking', 'water,psychic', './assets/slowking.png', 'Placeholder'),
(404, 200, 'Misdreavus', 'ghost', './assets/misdreavus.png', 'Placeholder'),
(405, 201, 'Unown', 'psychic', './assets/unown.png', 'Placeholder'),
(406, 202, 'Wobbuffet', 'psychic', './assets/wobbuffet.png', 'Placeholder'),
(407, 203, 'Girafarig', 'normaal,psychic', './assets/girafarig.png', 'Placeholder'),
(408, 204, 'Pineco', 'bug', './assets/pineco.png', 'Placeholder'),
(409, 205, 'Forretress', 'bug,steel', './assets/forretress.png', 'Placeholder');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pokemons`
--
ALTER TABLE `pokemons`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pokemons`
--
ALTER TABLE `pokemons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=410;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
