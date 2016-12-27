<?php

/**
 * Class for Google font Html element
 */
class Admin_Theme_Element_Select_Gfont extends Admin_Theme_Element_Select
{

	/**
	 * List of google fonts
	 * @see https://developers.google.com/webfonts/
	 */
	const FONT_LIST = '[{"family":"ABeeZee","variants":["regular","italic"],"subsets":["latin"]},{"family":"Abel","variants":["regular"],"subsets":["latin"]},{"family":"Abril Fatface","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Aclonica","variants":["regular"],"subsets":["latin"]},{"family":"Acme","variants":["regular"],"subsets":["latin"]},{"family":"Actor","variants":["regular"],"subsets":["latin"]},{"family":"Adamina","variants":["regular"],"subsets":["latin"]},{"family":"Advent Pro","variants":["100","200","300","regular","500","600","700"],"subsets":["latin","greek","latin-ext"]},{"family":"Aguafina Script","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Akronim","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Aladin","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Aldrich","variants":["regular"],"subsets":["latin"]},{"family":"Alef","variants":["regular","700"],"subsets":["latin"]},{"family":"Alegreya","variants":["regular","italic","700","700italic","900","900italic"],"subsets":["latin","latin-ext"]},{"family":"Alegreya SC","variants":["regular","italic","700","700italic","900","900italic"],"subsets":["latin","latin-ext"]},{"family":"Alegreya Sans","variants":["100","100italic","300","300italic","regular","italic","500","500italic","700","700italic","800","800italic","900","900italic"],"subsets":["vietnamese","latin","latin-ext"]},{"family":"Alegreya Sans SC","variants":["100","100italic","300","300italic","regular","italic","500","500italic","700","700italic","800","800italic","900","900italic"],"subsets":["vietnamese","latin","latin-ext"]},{"family":"Alex Brush","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Alfa Slab One","variants":["regular"],"subsets":["latin"]},{"family":"Alice","variants":["regular"],"subsets":["latin"]},{"family":"Alike","variants":["regular"],"subsets":["latin"]},{"family":"Alike Angular","variants":["regular"],"subsets":["latin"]},{"family":"Allan","variants":["regular","700"],"subsets":["latin","latin-ext"]},{"family":"Allerta","variants":["regular"],"subsets":["latin"]},{"family":"Allerta Stencil","variants":["regular"],"subsets":["latin"]},{"family":"Allura","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Almendra","variants":["regular","italic","700","700italic"],"subsets":["latin","latin-ext"]},{"family":"Almendra Display","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Almendra SC","variants":["regular"],"subsets":["latin"]},{"family":"Amarante","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Amaranth","variants":["regular","italic","700","700italic"],"subsets":["latin"]},{"family":"Amatic SC","variants":["regular","700"],"subsets":["latin"]},{"family":"Amethysta","variants":["regular"],"subsets":["latin"]},{"family":"Anaheim","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Andada","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Andika","variants":["regular"],"subsets":["cyrillic-ext","latin","latin-ext","cyrillic"]},{"family":"Angkor","variants":["regular"],"subsets":["khmer"]},{"family":"Annie Use Your Telescope","variants":["regular"],"subsets":["latin"]},{"family":"Anonymous Pro","variants":["regular","italic","700","700italic"],"subsets":["cyrillic-ext","latin","greek","greek-ext","latin-ext","cyrillic"]},{"family":"Antic","variants":["regular"],"subsets":["latin"]},{"family":"Antic Didone","variants":["regular"],"subsets":["latin"]},{"family":"Antic Slab","variants":["regular"],"subsets":["latin"]},{"family":"Anton","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Arapey","variants":["regular","italic"],"subsets":["latin"]},{"family":"Arbutus","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Arbutus Slab","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Architects Daughter","variants":["regular"],"subsets":["latin"]},{"family":"Archivo Black","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Archivo Narrow","variants":["regular","italic","700","700italic"],"subsets":["latin","latin-ext"]},{"family":"Arimo","variants":["regular","italic","700","700italic"],"subsets":["vietnamese","cyrillic-ext","latin","greek","greek-ext","latin-ext","cyrillic"]},{"family":"Arizonia","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Armata","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Artifika","variants":["regular"],"subsets":["latin"]},{"family":"Arvo","variants":["regular","italic","700","700italic"],"subsets":["latin"]},{"family":"Asap","variants":["regular","italic","700","700italic"],"subsets":["latin","latin-ext"]},{"family":"Asset","variants":["regular"],"subsets":["latin"]},{"family":"Astloch","variants":["regular","700"],"subsets":["latin"]},{"family":"Asul","variants":["regular","700"],"subsets":["latin"]},{"family":"Atomic Age","variants":["regular"],"subsets":["latin"]},{"family":"Aubrey","variants":["regular"],"subsets":["latin"]},{"family":"Audiowide","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Autour One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Average","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Average Sans","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Averia Gruesa Libre","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Averia Libre","variants":["300","300italic","regular","italic","700","700italic"],"subsets":["latin"]},{"family":"Averia Sans Libre","variants":["300","300italic","regular","italic","700","700italic"],"subsets":["latin"]},{"family":"Averia Serif Libre","variants":["300","300italic","regular","italic","700","700italic"],"subsets":["latin"]},{"family":"Bad Script","variants":["regular"],"subsets":["latin","cyrillic"]},{"family":"Balthazar","variants":["regular"],"subsets":["latin"]},{"family":"Bangers","variants":["regular"],"subsets":["latin"]},{"family":"Basic","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Battambang","variants":["regular","700"],"subsets":["khmer"]},{"family":"Baumans","variants":["regular"],"subsets":["latin"]},{"family":"Bayon","variants":["regular"],"subsets":["khmer"]},{"family":"Belgrano","variants":["regular"],"subsets":["latin"]},{"family":"Belleza","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"BenchNine","variants":["300","regular","700"],"subsets":["latin","latin-ext"]},{"family":"Bentham","variants":["regular"],"subsets":["latin"]},{"family":"Berkshire Swash","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Bevan","variants":["regular"],"subsets":["latin"]},{"family":"Bigelow Rules","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Bigshot One","variants":["regular"],"subsets":["latin"]},{"family":"Bilbo","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Bilbo Swash Caps","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Bitter","variants":["regular","italic","700"],"subsets":["latin","latin-ext"]},{"family":"Black Ops One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Bokor","variants":["regular"],"subsets":["khmer"]},{"family":"Bonbon","variants":["regular"],"subsets":["latin"]},{"family":"Boogaloo","variants":["regular"],"subsets":["latin"]},{"family":"Bowlby One","variants":["regular"],"subsets":["latin"]},{"family":"Bowlby One SC","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Brawler","variants":["regular"],"subsets":["latin"]},{"family":"Bree Serif","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Bubblegum Sans","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Bubbler One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Buda","variants":["300"],"subsets":["latin"]},{"family":"Buenard","variants":["regular","700"],"subsets":["latin","latin-ext"]},{"family":"Butcherman","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Butterfly Kids","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Cabin","variants":["regular","italic","500","500italic","600","600italic","700","700italic"],"subsets":["latin"]},{"family":"Cabin Condensed","variants":["regular","500","600","700"],"subsets":["latin"]},{"family":"Cabin Sketch","variants":["regular","700"],"subsets":["latin"]},{"family":"Caesar Dressing","variants":["regular"],"subsets":["latin"]},{"family":"Cagliostro","variants":["regular"],"subsets":["latin"]},{"family":"Calligraffitti","variants":["regular"],"subsets":["latin"]},{"family":"Cambo","variants":["regular"],"subsets":["latin"]},{"family":"Candal","variants":["regular"],"subsets":["latin"]},{"family":"Cantarell","variants":["regular","italic","700","700italic"],"subsets":["latin"]},{"family":"Cantata One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Cantora One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Capriola","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Cardo","variants":["regular","italic","700"],"subsets":["latin","greek","greek-ext","latin-ext"]},{"family":"Carme","variants":["regular"],"subsets":["latin"]},{"family":"Carrois Gothic","variants":["regular"],"subsets":["latin"]},{"family":"Carrois Gothic SC","variants":["regular"],"subsets":["latin"]},{"family":"Carter One","variants":["regular"],"subsets":["latin"]},{"family":"Caudex","variants":["regular","italic","700","700italic"],"subsets":["latin","greek","greek-ext","latin-ext"]},{"family":"Cedarville Cursive","variants":["regular"],"subsets":["latin"]},{"family":"Ceviche One","variants":["regular"],"subsets":["latin"]},{"family":"Changa One","variants":["regular","italic"],"subsets":["latin"]},{"family":"Chango","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Chau Philomene One","variants":["regular","italic"],"subsets":["latin","latin-ext"]},{"family":"Chela One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Chelsea Market","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Chenla","variants":["regular"],"subsets":["khmer"]},{"family":"Cherry Cream Soda","variants":["regular"],"subsets":["latin"]},{"family":"Cherry Swash","variants":["regular","700"],"subsets":["latin","latin-ext"]},{"family":"Chewy","variants":["regular"],"subsets":["latin"]},{"family":"Chicle","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Chivo","variants":["regular","italic","900","900italic"],"subsets":["latin"]},{"family":"Cinzel","variants":["regular","700","900"],"subsets":["latin"]},{"family":"Cinzel Decorative","variants":["regular","700","900"],"subsets":["latin"]},{"family":"Clicker Script","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Coda","variants":["regular","800"],"subsets":["latin"]},{"family":"Coda Caption","variants":["800"],"subsets":["latin"]},{"family":"Codystar","variants":["300","regular"],"subsets":["latin","latin-ext"]},{"family":"Combo","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Comfortaa","variants":["300","regular","700"],"subsets":["cyrillic-ext","latin","greek","latin-ext","cyrillic"]},{"family":"Coming Soon","variants":["regular"],"subsets":["latin"]},{"family":"Concert One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Condiment","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Content","variants":["regular","700"],"subsets":["khmer"]},{"family":"Contrail One","variants":["regular"],"subsets":["latin"]},{"family":"Convergence","variants":["regular"],"subsets":["latin"]},{"family":"Cookie","variants":["regular"],"subsets":["latin"]},{"family":"Copse","variants":["regular"],"subsets":["latin"]},{"family":"Corben","variants":["regular","700"],"subsets":["latin"]},{"family":"Courgette","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Cousine","variants":["regular","italic","700","700italic"],"subsets":["vietnamese","cyrillic-ext","latin","greek","greek-ext","latin-ext","cyrillic"]},{"family":"Coustard","variants":["regular","900"],"subsets":["latin"]},{"family":"Covered By Your Grace","variants":["regular"],"subsets":["latin"]},{"family":"Crafty Girls","variants":["regular"],"subsets":["latin"]},{"family":"Creepster","variants":["regular"],"subsets":["latin"]},{"family":"Crete Round","variants":["regular","italic"],"subsets":["latin","latin-ext"]},{"family":"Crimson Text","variants":["regular","italic","600","600italic","700","700italic"],"subsets":["latin"]},{"family":"Croissant One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Crushed","variants":["regular"],"subsets":["latin"]},{"family":"Cuprum","variants":["regular","italic","700","700italic"],"subsets":["latin","latin-ext","cyrillic"]},{"family":"Cutive","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Cutive Mono","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Damion","variants":["regular"],"subsets":["latin"]},{"family":"Dancing Script","variants":["regular","700"],"subsets":["latin"]},{"family":"Dangrek","variants":["regular"],"subsets":["khmer"]},{"family":"Dawning of a New Day","variants":["regular"],"subsets":["latin"]},{"family":"Days One","variants":["regular"],"subsets":["latin"]},{"family":"Delius","variants":["regular"],"subsets":["latin"]},{"family":"Delius Swash Caps","variants":["regular"],"subsets":["latin"]},{"family":"Delius Unicase","variants":["regular","700"],"subsets":["latin"]},{"family":"Della Respira","variants":["regular"],"subsets":["latin"]},{"family":"Denk One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Devonshire","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Didact Gothic","variants":["regular"],"subsets":["cyrillic-ext","latin","greek","greek-ext","latin-ext","cyrillic"]},{"family":"Diplomata","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Diplomata SC","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Domine","variants":["regular","700"],"subsets":["latin","latin-ext"]},{"family":"Donegal One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Doppio One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Dorsa","variants":["regular"],"subsets":["latin"]},{"family":"Dosis","variants":["200","300","regular","500","600","700","800"],"subsets":["latin","latin-ext"]},{"family":"Dr Sugiyama","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Droid Sans","variants":["regular","700"],"subsets":["latin"]},{"family":"Droid Sans Mono","variants":["regular"],"subsets":["latin"]},{"family":"Droid Serif","variants":["regular","italic","700","700italic"],"subsets":["latin"]},{"family":"Duru Sans","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Dynalight","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"EB Garamond","variants":["regular"],"subsets":["vietnamese","cyrillic-ext","latin","latin-ext","cyrillic"]},{"family":"Eagle Lake","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Eater","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Economica","variants":["regular","italic","700","700italic"],"subsets":["latin","latin-ext"]},{"family":"Ek Mukta","variants":["200","300","regular","500","600","700","800"],"subsets":["devanagari","latin","latin-ext"]},{"family":"Electrolize","variants":["regular"],"subsets":["latin"]},{"family":"Elsie","variants":["regular","900"],"subsets":["latin","latin-ext"]},{"family":"Elsie Swash Caps","variants":["regular","900"],"subsets":["latin","latin-ext"]},{"family":"Emblema One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Emilys Candy","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Engagement","variants":["regular"],"subsets":["latin"]},{"family":"Englebert","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Enriqueta","variants":["regular","700"],"subsets":["latin","latin-ext"]},{"family":"Erica One","variants":["regular"],"subsets":["latin"]},{"family":"Esteban","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Euphoria Script","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Ewert","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Exo","variants":["100","100italic","200","200italic","300","300italic","regular","italic","500","500italic","600","600italic","700","700italic","800","800italic","900","900italic"],"subsets":["latin","latin-ext"]},{"family":"Exo 2","variants":["100","100italic","200","200italic","300","300italic","regular","italic","500","500italic","600","600italic","700","700italic","800","800italic","900","900italic"],"subsets":["latin","latin-ext","cyrillic"]},{"family":"Expletus Sans","variants":["regular","italic","500","500italic","600","600italic","700","700italic"],"subsets":["latin"]},{"family":"Fanwood Text","variants":["regular","italic"],"subsets":["latin"]},{"family":"Fascinate","variants":["regular"],"subsets":["latin"]},{"family":"Fascinate Inline","variants":["regular"],"subsets":["latin"]},{"family":"Faster One","variants":["regular"],"subsets":["latin"]},{"family":"Fasthand","variants":["regular"],"subsets":["khmer"]},{"family":"Fauna One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Federant","variants":["regular"],"subsets":["latin"]},{"family":"Federo","variants":["regular"],"subsets":["latin"]},{"family":"Felipa","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Fenix","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Finger Paint","variants":["regular"],"subsets":["latin"]},{"family":"Fira Mono","variants":["regular","700"],"subsets":["vietnamese","cyrillic-ext","latin","greek","latin-ext","cyrillic"]},{"family":"Fira Sans","variants":["300","300italic","regular","italic","500","500italic","700","700italic"],"subsets":["cyrillic-ext","latin","greek","latin-ext","cyrillic"]},{"family":"Fjalla One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Fjord One","variants":["regular"],"subsets":["latin"]},{"family":"Flamenco","variants":["300","regular"],"subsets":["latin"]},{"family":"Flavors","variants":["regular"],"subsets":["latin"]},{"family":"Fondamento","variants":["regular","italic"],"subsets":["latin","latin-ext"]},{"family":"Fontdiner Swanky","variants":["regular"],"subsets":["latin"]},{"family":"Forum","variants":["regular"],"subsets":["cyrillic-ext","latin","latin-ext","cyrillic"]},{"family":"Francois One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Freckle Face","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Fredericka the Great","variants":["regular"],"subsets":["latin"]},{"family":"Fredoka One","variants":["regular"],"subsets":["latin"]},{"family":"Freehand","variants":["regular"],"subsets":["khmer"]},{"family":"Fresca","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Frijole","variants":["regular"],"subsets":["latin"]},{"family":"Fruktur","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Fugaz One","variants":["regular"],"subsets":["latin"]},{"family":"GFS Didot","variants":["regular"],"subsets":["greek"]},{"family":"GFS Neohellenic","variants":["regular","italic","700","700italic"],"subsets":["greek"]},{"family":"Gabriela","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Gafata","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Galdeano","variants":["regular"],"subsets":["latin"]},{"family":"Galindo","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Gentium Basic","variants":["regular","italic","700","700italic"],"subsets":["latin","latin-ext"]},{"family":"Gentium Book Basic","variants":["regular","italic","700","700italic"],"subsets":["latin","latin-ext"]},{"family":"Geo","variants":["regular","italic"],"subsets":["latin"]},{"family":"Geostar","variants":["regular"],"subsets":["latin"]},{"family":"Geostar Fill","variants":["regular"],"subsets":["latin"]},{"family":"Germania One","variants":["regular"],"subsets":["latin"]},{"family":"Gilda Display","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Give You Glory","variants":["regular"],"subsets":["latin"]},{"family":"Glass Antiqua","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Glegoo","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Gloria Hallelujah","variants":["regular"],"subsets":["latin"]},{"family":"Goblin One","variants":["regular"],"subsets":["latin"]},{"family":"Gochi Hand","variants":["regular"],"subsets":["latin"]},{"family":"Gorditas","variants":["regular","700"],"subsets":["latin"]},{"family":"Goudy Bookletter 1911","variants":["regular"],"subsets":["latin"]},{"family":"Graduate","variants":["regular"],"subsets":["latin"]},{"family":"Grand Hotel","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Gravitas One","variants":["regular"],"subsets":["latin"]},{"family":"Great Vibes","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Griffy","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Gruppo","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Gudea","variants":["regular","italic","700"],"subsets":["latin","latin-ext"]},{"family":"Habibi","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Hammersmith One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Hanalei","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Hanalei Fill","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Handlee","variants":["regular"],"subsets":["latin"]},{"family":"Hanuman","variants":["regular","700"],"subsets":["khmer"]},{"family":"Happy Monkey","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Headland One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Henny Penny","variants":["regular"],"subsets":["latin"]},{"family":"Herr Von Muellerhoff","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Holtwood One SC","variants":["regular"],"subsets":["latin"]},{"family":"Homemade Apple","variants":["regular"],"subsets":["latin"]},{"family":"Homenaje","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"IM Fell DW Pica","variants":["regular","italic"],"subsets":["latin"]},{"family":"IM Fell DW Pica SC","variants":["regular"],"subsets":["latin"]},{"family":"IM Fell Double Pica","variants":["regular","italic"],"subsets":["latin"]},{"family":"IM Fell Double Pica SC","variants":["regular"],"subsets":["latin"]},{"family":"IM Fell English","variants":["regular","italic"],"subsets":["latin"]},{"family":"IM Fell English SC","variants":["regular"],"subsets":["latin"]},{"family":"IM Fell French Canon","variants":["regular","italic"],"subsets":["latin"]},{"family":"IM Fell French Canon SC","variants":["regular"],"subsets":["latin"]},{"family":"IM Fell Great Primer","variants":["regular","italic"],"subsets":["latin"]},{"family":"IM Fell Great Primer SC","variants":["regular"],"subsets":["latin"]},{"family":"Iceberg","variants":["regular"],"subsets":["latin"]},{"family":"Iceland","variants":["regular"],"subsets":["latin"]},{"family":"Imprima","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Inconsolata","variants":["regular","700"],"subsets":["latin","latin-ext"]},{"family":"Inder","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Indie Flower","variants":["regular"],"subsets":["latin"]},{"family":"Inika","variants":["regular","700"],"subsets":["latin","latin-ext"]},{"family":"Irish Grover","variants":["regular"],"subsets":["latin"]},{"family":"Istok Web","variants":["regular","italic","700","700italic"],"subsets":["cyrillic-ext","latin","latin-ext","cyrillic"]},{"family":"Italiana","variants":["regular"],"subsets":["latin"]},{"family":"Italianno","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Jacques Francois","variants":["regular"],"subsets":["latin"]},{"family":"Jacques Francois Shadow","variants":["regular"],"subsets":["latin"]},{"family":"Jim Nightshade","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Jockey One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Jolly Lodger","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Josefin Sans","variants":["100","100italic","300","300italic","regular","italic","600","600italic","700","700italic"],"subsets":["latin"]},{"family":"Josefin Slab","variants":["100","100italic","300","300italic","regular","italic","600","600italic","700","700italic"],"subsets":["latin"]},{"family":"Joti One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Judson","variants":["regular","italic","700"],"subsets":["latin"]},{"family":"Julee","variants":["regular"],"subsets":["latin"]},{"family":"Julius Sans One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Junge","variants":["regular"],"subsets":["latin"]},{"family":"Jura","variants":["300","regular","500","600"],"subsets":["cyrillic-ext","latin","greek","greek-ext","latin-ext","cyrillic"]},{"family":"Just Another Hand","variants":["regular"],"subsets":["latin"]},{"family":"Just Me Again Down Here","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Kameron","variants":["regular","700"],"subsets":["latin"]},{"family":"Kantumruy","variants":["300","regular","700"],"subsets":["khmer"]},{"family":"Karla","variants":["regular","italic","700","700italic"],"subsets":["latin","latin-ext"]},{"family":"Kaushan Script","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Kavoon","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Kdam Thmor","variants":["regular"],"subsets":["khmer"]},{"family":"Keania One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Kelly Slab","variants":["regular"],"subsets":["latin","latin-ext","cyrillic"]},{"family":"Kenia","variants":["regular"],"subsets":["latin"]},{"family":"Khmer","variants":["regular"],"subsets":["khmer"]},{"family":"Kite One","variants":["regular"],"subsets":["latin"]},{"family":"Knewave","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Kotta One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Koulen","variants":["regular"],"subsets":["khmer"]},{"family":"Kranky","variants":["regular"],"subsets":["latin"]},{"family":"Kreon","variants":["300","regular","700"],"subsets":["latin"]},{"family":"Kristi","variants":["regular"],"subsets":["latin"]},{"family":"Krona One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"La Belle Aurore","variants":["regular"],"subsets":["latin"]},{"family":"Lancelot","variants":["regular"],"subsets":["latin"]},{"family":"Lato","variants":["100","100italic","300","300italic","regular","italic","700","700italic","900","900italic"],"subsets":["latin"]},{"family":"League Script","variants":["regular"],"subsets":["latin"]},{"family":"Leckerli One","variants":["regular"],"subsets":["latin"]},{"family":"Ledger","variants":["regular"],"subsets":["latin","latin-ext","cyrillic"]},{"family":"Lekton","variants":["regular","italic","700"],"subsets":["latin","latin-ext"]},{"family":"Lemon","variants":["regular"],"subsets":["latin"]},{"family":"Libre Baskerville","variants":["regular","italic","700"],"subsets":["latin","latin-ext"]},{"family":"Life Savers","variants":["regular","700"],"subsets":["latin","latin-ext"]},{"family":"Lilita One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Lily Script One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Limelight","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Linden Hill","variants":["regular","italic"],"subsets":["latin"]},{"family":"Lobster","variants":["regular"],"subsets":["cyrillic-ext","latin","latin-ext","cyrillic"]},{"family":"Lobster Two","variants":["regular","italic","700","700italic"],"subsets":["latin"]},{"family":"Londrina Outline","variants":["regular"],"subsets":["latin"]},{"family":"Londrina Shadow","variants":["regular"],"subsets":["latin"]},{"family":"Londrina Sketch","variants":["regular"],"subsets":["latin"]},{"family":"Londrina Solid","variants":["regular"],"subsets":["latin"]},{"family":"Lora","variants":["regular","italic","700","700italic"],"subsets":["latin","latin-ext","cyrillic"]},{"family":"Love Ya Like A Sister","variants":["regular"],"subsets":["latin"]},{"family":"Loved by the King","variants":["regular"],"subsets":["latin"]},{"family":"Lovers Quarrel","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Luckiest Guy","variants":["regular"],"subsets":["latin"]},{"family":"Lusitana","variants":["regular","700"],"subsets":["latin"]},{"family":"Lustria","variants":["regular"],"subsets":["latin"]},{"family":"Macondo","variants":["regular"],"subsets":["latin"]},{"family":"Macondo Swash Caps","variants":["regular"],"subsets":["latin"]},{"family":"Magra","variants":["regular","700"],"subsets":["latin","latin-ext"]},{"family":"Maiden Orange","variants":["regular"],"subsets":["latin"]},{"family":"Mako","variants":["regular"],"subsets":["latin"]},{"family":"Marcellus","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Marcellus SC","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Marck Script","variants":["regular"],"subsets":["latin","latin-ext","cyrillic"]},{"family":"Margarine","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Marko One","variants":["regular"],"subsets":["latin"]},{"family":"Marmelad","variants":["regular"],"subsets":["latin","latin-ext","cyrillic"]},{"family":"Marvel","variants":["regular","italic","700","700italic"],"subsets":["latin"]},{"family":"Mate","variants":["regular","italic"],"subsets":["latin"]},{"family":"Mate SC","variants":["regular"],"subsets":["latin"]},{"family":"Maven Pro","variants":["regular","500","700","900"],"subsets":["latin"]},{"family":"McLaren","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Meddon","variants":["regular"],"subsets":["latin"]},{"family":"MedievalSharp","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Medula One","variants":["regular"],"subsets":["latin"]},{"family":"Megrim","variants":["regular"],"subsets":["latin"]},{"family":"Meie Script","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Merienda","variants":["regular","700"],"subsets":["latin","latin-ext"]},{"family":"Merienda One","variants":["regular"],"subsets":["latin"]},{"family":"Merriweather","variants":["300","300italic","regular","italic","700","700italic","900","900italic"],"subsets":["latin","latin-ext"]},{"family":"Merriweather Sans","variants":["300","300italic","regular","italic","700","700italic","800","800italic"],"subsets":["latin","latin-ext"]},{"family":"Metal","variants":["regular"],"subsets":["khmer"]},{"family":"Metal Mania","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Metamorphous","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Metrophobic","variants":["regular"],"subsets":["latin"]},{"family":"Michroma","variants":["regular"],"subsets":["latin"]},{"family":"Milonga","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Miltonian","variants":["regular"],"subsets":["latin"]},{"family":"Miltonian Tattoo","variants":["regular"],"subsets":["latin"]},{"family":"Miniver","variants":["regular"],"subsets":["latin"]},{"family":"Miss Fajardose","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Modern Antiqua","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Molengo","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Molle","variants":["italic"],"subsets":["latin","latin-ext"]},{"family":"Monda","variants":["regular","700"],"subsets":["latin","latin-ext"]},{"family":"Monofett","variants":["regular"],"subsets":["latin"]},{"family":"Monoton","variants":["regular"],"subsets":["latin"]},{"family":"Monsieur La Doulaise","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Montaga","variants":["regular"],"subsets":["latin"]},{"family":"Montez","variants":["regular"],"subsets":["latin"]},{"family":"Montserrat","variants":["regular","700"],"subsets":["latin"]},{"family":"Montserrat Alternates","variants":["regular","700"],"subsets":["latin"]},{"family":"Montserrat Subrayada","variants":["regular","700"],"subsets":["latin"]},{"family":"Moul","variants":["regular"],"subsets":["khmer"]},{"family":"Moulpali","variants":["regular"],"subsets":["khmer"]},{"family":"Mountains of Christmas","variants":["regular","700"],"subsets":["latin"]},{"family":"Mouse Memoirs","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Mr Bedfort","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Mr Dafoe","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Mr De Haviland","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Mrs Saint Delafield","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Mrs Sheppards","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Muli","variants":["300","300italic","regular","italic"],"subsets":["latin"]},{"family":"Mystery Quest","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Neucha","variants":["regular"],"subsets":["latin","cyrillic"]},{"family":"Neuton","variants":["200","300","regular","italic","700","800"],"subsets":["latin","latin-ext"]},{"family":"New Rocker","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"News Cycle","variants":["regular","700"],"subsets":["latin","latin-ext"]},{"family":"Niconne","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Nixie One","variants":["regular"],"subsets":["latin"]},{"family":"Nobile","variants":["regular","italic","700","700italic"],"subsets":["latin"]},{"family":"Nokora","variants":["regular","700"],"subsets":["khmer"]},{"family":"Norican","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Nosifer","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Nothing You Could Do","variants":["regular"],"subsets":["latin"]},{"family":"Noticia Text","variants":["regular","italic","700","700italic"],"subsets":["vietnamese","latin","latin-ext"]},{"family":"Noto Sans","variants":["regular","italic","700","700italic"],"subsets":["vietnamese","cyrillic-ext","devanagari","latin","greek","greek-ext","latin-ext","cyrillic"]},{"family":"Noto Serif","variants":["regular","italic","700","700italic"],"subsets":["vietnamese","cyrillic-ext","latin","greek","greek-ext","latin-ext","cyrillic"]},{"family":"Nova Cut","variants":["regular"],"subsets":["latin"]},{"family":"Nova Flat","variants":["regular"],"subsets":["latin"]},{"family":"Nova Mono","variants":["regular"],"subsets":["latin","greek"]},{"family":"Nova Oval","variants":["regular"],"subsets":["latin"]},{"family":"Nova Round","variants":["regular"],"subsets":["latin"]},{"family":"Nova Script","variants":["regular"],"subsets":["latin"]},{"family":"Nova Slim","variants":["regular"],"subsets":["latin"]},{"family":"Nova Square","variants":["regular"],"subsets":["latin"]},{"family":"Numans","variants":["regular"],"subsets":["latin"]},{"family":"Nunito","variants":["300","regular","700"],"subsets":["latin"]},{"family":"Odor Mean Chey","variants":["regular"],"subsets":["khmer"]},{"family":"Offside","variants":["regular"],"subsets":["latin"]},{"family":"Old Standard TT","variants":["regular","italic","700"],"subsets":["latin"]},{"family":"Oldenburg","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Oleo Script","variants":["regular","700"],"subsets":["latin","latin-ext"]},{"family":"Oleo Script Swash Caps","variants":["regular","700"],"subsets":["latin","latin-ext"]},{"family":"Open Sans","variants":["300","300italic","regular","italic","600","600italic","700","700italic","800","800italic"],"subsets":["vietnamese","cyrillic-ext","devanagari","latin","greek","greek-ext","latin-ext","cyrillic"]},{"family":"Open Sans Condensed","variants":["300","300italic","700"],"subsets":["vietnamese","cyrillic-ext","latin","greek","greek-ext","latin-ext","cyrillic"]},{"family":"Oranienbaum","variants":["regular"],"subsets":["cyrillic-ext","latin","latin-ext","cyrillic"]},{"family":"Orbitron","variants":["regular","500","700","900"],"subsets":["latin"]},{"family":"Oregano","variants":["regular","italic"],"subsets":["latin","latin-ext"]},{"family":"Orienta","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Original Surfer","variants":["regular"],"subsets":["latin"]},{"family":"Oswald","variants":["300","regular","700"],"subsets":["latin","latin-ext"]},{"family":"Over the Rainbow","variants":["regular"],"subsets":["latin"]},{"family":"Overlock","variants":["regular","italic","700","700italic","900","900italic"],"subsets":["latin","latin-ext"]},{"family":"Overlock SC","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Ovo","variants":["regular"],"subsets":["latin"]},{"family":"Oxygen","variants":["300","regular","700"],"subsets":["latin","latin-ext"]},{"family":"Oxygen Mono","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"PT Mono","variants":["regular"],"subsets":["cyrillic-ext","latin","latin-ext","cyrillic"]},{"family":"PT Sans","variants":["regular","italic","700","700italic"],"subsets":["cyrillic-ext","latin","latin-ext","cyrillic"]},{"family":"PT Sans Caption","variants":["regular","700"],"subsets":["cyrillic-ext","latin","latin-ext","cyrillic"]},{"family":"PT Sans Narrow","variants":["regular","700"],"subsets":["cyrillic-ext","latin","latin-ext","cyrillic"]},{"family":"PT Serif","variants":["regular","italic","700","700italic"],"subsets":["cyrillic-ext","latin","latin-ext","cyrillic"]},{"family":"PT Serif Caption","variants":["regular","italic"],"subsets":["cyrillic-ext","latin","latin-ext","cyrillic"]},{"family":"Pacifico","variants":["regular"],"subsets":["latin"]},{"family":"Paprika","variants":["regular"],"subsets":["latin"]},{"family":"Parisienne","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Passero One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Passion One","variants":["regular","700","900"],"subsets":["latin","latin-ext"]},{"family":"Pathway Gothic One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Patrick Hand","variants":["regular"],"subsets":["vietnamese","latin","latin-ext"]},{"family":"Patrick Hand SC","variants":["regular"],"subsets":["vietnamese","latin","latin-ext"]},{"family":"Patua One","variants":["regular"],"subsets":["latin"]},{"family":"Paytone One","variants":["regular"],"subsets":["latin"]},{"family":"Peralta","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Permanent Marker","variants":["regular"],"subsets":["latin"]},{"family":"Petit Formal Script","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Petrona","variants":["regular"],"subsets":["latin"]},{"family":"Philosopher","variants":["regular","italic","700","700italic"],"subsets":["latin","cyrillic"]},{"family":"Piedra","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Pinyon Script","variants":["regular"],"subsets":["latin"]},{"family":"Pirata One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Plaster","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Play","variants":["regular","700"],"subsets":["cyrillic-ext","latin","greek","greek-ext","latin-ext","cyrillic"]},{"family":"Playball","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Playfair Display","variants":["regular","italic","700","700italic","900","900italic"],"subsets":["latin","latin-ext","cyrillic"]},{"family":"Playfair Display SC","variants":["regular","italic","700","700italic","900","900italic"],"subsets":["latin","latin-ext","cyrillic"]},{"family":"Podkova","variants":["regular","700"],"subsets":["latin"]},{"family":"Poiret One","variants":["regular"],"subsets":["latin","latin-ext","cyrillic"]},{"family":"Poller One","variants":["regular"],"subsets":["latin"]},{"family":"Poly","variants":["regular","italic"],"subsets":["latin"]},{"family":"Pompiere","variants":["regular"],"subsets":["latin"]},{"family":"Pontano Sans","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Port Lligat Sans","variants":["regular"],"subsets":["latin"]},{"family":"Port Lligat Slab","variants":["regular"],"subsets":["latin"]},{"family":"Prata","variants":["regular"],"subsets":["latin"]},{"family":"Preahvihear","variants":["regular"],"subsets":["khmer"]},{"family":"Press Start 2P","variants":["regular"],"subsets":["latin","greek","latin-ext","cyrillic"]},{"family":"Princess Sofia","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Prociono","variants":["regular"],"subsets":["latin"]},{"family":"Prosto One","variants":["regular"],"subsets":["latin","latin-ext","cyrillic"]},{"family":"Puritan","variants":["regular","italic","700","700italic"],"subsets":["latin"]},{"family":"Purple Purse","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Quando","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Quantico","variants":["regular","italic","700","700italic"],"subsets":["latin"]},{"family":"Quattrocento","variants":["regular","700"],"subsets":["latin","latin-ext"]},{"family":"Quattrocento Sans","variants":["regular","italic","700","700italic"],"subsets":["latin","latin-ext"]},{"family":"Questrial","variants":["regular"],"subsets":["latin"]},{"family":"Quicksand","variants":["300","regular","700"],"subsets":["latin"]},{"family":"Quintessential","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Qwigley","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Racing Sans One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Radley","variants":["regular","italic"],"subsets":["latin","latin-ext"]},{"family":"Raleway","variants":["100","200","300","regular","500","600","700","800","900"],"subsets":["latin"]},{"family":"Raleway Dots","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Rambla","variants":["regular","italic","700","700italic"],"subsets":["latin","latin-ext"]},{"family":"Rammetto One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Ranchers","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Rancho","variants":["regular"],"subsets":["latin"]},{"family":"Rationale","variants":["regular"],"subsets":["latin"]},{"family":"Redressed","variants":["regular"],"subsets":["latin"]},{"family":"Reenie Beanie","variants":["regular"],"subsets":["latin"]},{"family":"Revalia","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Ribeye","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Ribeye Marrow","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Righteous","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Risque","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Roboto","variants":["100","100italic","300","300italic","regular","italic","500","500italic","700","700italic","900","900italic"],"subsets":["vietnamese","cyrillic-ext","latin","greek","greek-ext","latin-ext","cyrillic"]},{"family":"Roboto Condensed","variants":["300","300italic","regular","italic","700","700italic"],"subsets":["vietnamese","cyrillic-ext","latin","greek","greek-ext","latin-ext","cyrillic"]},{"family":"Roboto Slab","variants":["100","300","regular","700"],"subsets":["vietnamese","cyrillic-ext","latin","greek","greek-ext","latin-ext","cyrillic"]},{"family":"Rochester","variants":["regular"],"subsets":["latin"]},{"family":"Rock Salt","variants":["regular"],"subsets":["latin"]},{"family":"Rokkitt","variants":["regular","700"],"subsets":["latin"]},{"family":"Romanesco","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Ropa Sans","variants":["regular","italic"],"subsets":["latin","latin-ext"]},{"family":"Rosario","variants":["regular","italic","700","700italic"],"subsets":["latin"]},{"family":"Rosarivo","variants":["regular","italic"],"subsets":["latin","latin-ext"]},{"family":"Rouge Script","variants":["regular"],"subsets":["latin"]},{"family":"Rubik Mono One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Rubik One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Ruda","variants":["regular","700","900"],"subsets":["latin","latin-ext"]},{"family":"Rufina","variants":["regular","700"],"subsets":["latin","latin-ext"]},{"family":"Ruge Boogie","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Ruluko","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Rum Raisin","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Ruslan Display","variants":["regular"],"subsets":["cyrillic-ext","latin","latin-ext","cyrillic"]},{"family":"Russo One","variants":["regular"],"subsets":["latin","latin-ext","cyrillic"]},{"family":"Ruthie","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Rye","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Sacramento","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Sail","variants":["regular"],"subsets":["latin"]},{"family":"Salsa","variants":["regular"],"subsets":["latin"]},{"family":"Sanchez","variants":["regular","italic"],"subsets":["latin","latin-ext"]},{"family":"Sancreek","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Sansita One","variants":["regular"],"subsets":["latin"]},{"family":"Sarina","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Satisfy","variants":["regular"],"subsets":["latin"]},{"family":"Scada","variants":["regular","italic","700","700italic"],"subsets":["latin","latin-ext","cyrillic"]},{"family":"Schoolbell","variants":["regular"],"subsets":["latin"]},{"family":"Seaweed Script","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Sevillana","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Seymour One","variants":["regular"],"subsets":["latin","latin-ext","cyrillic"]},{"family":"Shadows Into Light","variants":["regular"],"subsets":["latin"]},{"family":"Shadows Into Light Two","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Shanti","variants":["regular"],"subsets":["latin"]},{"family":"Share","variants":["regular","italic","700","700italic"],"subsets":["latin","latin-ext"]},{"family":"Share Tech","variants":["regular"],"subsets":["latin"]},{"family":"Share Tech Mono","variants":["regular"],"subsets":["latin"]},{"family":"Shojumaru","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Short Stack","variants":["regular"],"subsets":["latin"]},{"family":"Siemreap","variants":["regular"],"subsets":["khmer"]},{"family":"Sigmar One","variants":["regular"],"subsets":["latin"]},{"family":"Signika","variants":["300","regular","600","700"],"subsets":["latin","latin-ext"]},{"family":"Signika Negative","variants":["300","regular","600","700"],"subsets":["latin","latin-ext"]},{"family":"Simonetta","variants":["regular","italic","900","900italic"],"subsets":["latin","latin-ext"]},{"family":"Sintony","variants":["regular","700"],"subsets":["latin","latin-ext"]},{"family":"Sirin Stencil","variants":["regular"],"subsets":["latin"]},{"family":"Six Caps","variants":["regular"],"subsets":["latin"]},{"family":"Skranji","variants":["regular","700"],"subsets":["latin","latin-ext"]},{"family":"Slackey","variants":["regular"],"subsets":["latin"]},{"family":"Smokum","variants":["regular"],"subsets":["latin"]},{"family":"Smythe","variants":["regular"],"subsets":["latin"]},{"family":"Sniglet","variants":["regular","800"],"subsets":["latin","latin-ext"]},{"family":"Snippet","variants":["regular"],"subsets":["latin"]},{"family":"Snowburst One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Sofadi One","variants":["regular"],"subsets":["latin"]},{"family":"Sofia","variants":["regular"],"subsets":["latin"]},{"family":"Sonsie One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Sorts Mill Goudy","variants":["regular","italic"],"subsets":["latin","latin-ext"]},{"family":"Source Code Pro","variants":["200","300","regular","500","600","700","900"],"subsets":["latin","latin-ext"]},{"family":"Source Sans Pro","variants":["200","200italic","300","300italic","regular","italic","600","600italic","700","700italic","900","900italic"],"subsets":["vietnamese","latin","latin-ext"]},{"family":"Source Serif Pro","variants":["regular","600","700"],"subsets":["latin","latin-ext"]},{"family":"Special Elite","variants":["regular"],"subsets":["latin"]},{"family":"Spicy Rice","variants":["regular"],"subsets":["latin"]},{"family":"Spinnaker","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Spirax","variants":["regular"],"subsets":["latin"]},{"family":"Squada One","variants":["regular"],"subsets":["latin"]},{"family":"Stalemate","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Stalinist One","variants":["regular"],"subsets":["latin","latin-ext","cyrillic"]},{"family":"Stardos Stencil","variants":["regular","700"],"subsets":["latin"]},{"family":"Stint Ultra Condensed","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Stint Ultra Expanded","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Stoke","variants":["300","regular"],"subsets":["latin","latin-ext"]},{"family":"Strait","variants":["regular"],"subsets":["latin"]},{"family":"Sue Ellen Francisco","variants":["regular"],"subsets":["latin"]},{"family":"Sunshiney","variants":["regular"],"subsets":["latin"]},{"family":"Supermercado One","variants":["regular"],"subsets":["latin"]},{"family":"Suwannaphum","variants":["regular"],"subsets":["khmer"]},{"family":"Swanky and Moo Moo","variants":["regular"],"subsets":["latin"]},{"family":"Syncopate","variants":["regular","700"],"subsets":["latin"]},{"family":"Tangerine","variants":["regular","700"],"subsets":["latin"]},{"family":"Taprom","variants":["regular"],"subsets":["khmer"]},{"family":"Tauri","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Telex","variants":["regular"],"subsets":["latin"]},{"family":"Tenor Sans","variants":["regular"],"subsets":["cyrillic-ext","latin","latin-ext","cyrillic"]},{"family":"Text Me One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"The Girl Next Door","variants":["regular"],"subsets":["latin"]},{"family":"Tienne","variants":["regular","700","900"],"subsets":["latin"]},{"family":"Tinos","variants":["regular","italic","700","700italic"],"subsets":["vietnamese","cyrillic-ext","latin","greek","greek-ext","latin-ext","cyrillic"]},{"family":"Titan One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Titillium Web","variants":["200","200italic","300","300italic","regular","italic","600","600italic","700","700italic","900"],"subsets":["latin","latin-ext"]},{"family":"Trade Winds","variants":["regular"],"subsets":["latin"]},{"family":"Trocchi","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Trochut","variants":["regular","italic","700"],"subsets":["latin"]},{"family":"Trykker","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Tulpen One","variants":["regular"],"subsets":["latin"]},{"family":"Ubuntu","variants":["300","300italic","regular","italic","500","500italic","700","700italic"],"subsets":["cyrillic-ext","latin","greek","greek-ext","latin-ext","cyrillic"]},{"family":"Ubuntu Condensed","variants":["regular"],"subsets":["cyrillic-ext","latin","greek","greek-ext","latin-ext","cyrillic"]},{"family":"Ubuntu Mono","variants":["regular","italic","700","700italic"],"subsets":["cyrillic-ext","latin","greek","greek-ext","latin-ext","cyrillic"]},{"family":"Ultra","variants":["regular"],"subsets":["latin"]},{"family":"Uncial Antiqua","variants":["regular"],"subsets":["latin"]},{"family":"Underdog","variants":["regular"],"subsets":["latin","latin-ext","cyrillic"]},{"family":"Unica One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"UnifrakturCook","variants":["700"],"subsets":["latin"]},{"family":"UnifrakturMaguntia","variants":["regular"],"subsets":["latin"]},{"family":"Unkempt","variants":["regular","700"],"subsets":["latin"]},{"family":"Unlock","variants":["regular"],"subsets":["latin"]},{"family":"Unna","variants":["regular"],"subsets":["latin"]},{"family":"VT323","variants":["regular"],"subsets":["latin"]},{"family":"Vampiro One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Varela","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Varela Round","variants":["regular"],"subsets":["latin"]},{"family":"Vast Shadow","variants":["regular"],"subsets":["latin"]},{"family":"Vibur","variants":["regular"],"subsets":["latin"]},{"family":"Vidaloka","variants":["regular"],"subsets":["latin"]},{"family":"Viga","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Voces","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Volkhov","variants":["regular","italic","700","700italic"],"subsets":["latin"]},{"family":"Vollkorn","variants":["regular","italic","700","700italic"],"subsets":["latin"]},{"family":"Voltaire","variants":["regular"],"subsets":["latin"]},{"family":"Waiting for the Sunrise","variants":["regular"],"subsets":["latin"]},{"family":"Wallpoet","variants":["regular"],"subsets":["latin"]},{"family":"Walter Turncoat","variants":["regular"],"subsets":["latin"]},{"family":"Warnes","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Wellfleet","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Wendy One","variants":["regular"],"subsets":["latin","latin-ext"]},{"family":"Wire One","variants":["regular"],"subsets":["latin"]},{"family":"Yanone Kaffeesatz","variants":["200","300","regular","700"],"subsets":["latin","latin-ext"]},{"family":"Yellowtail","variants":["regular"],"subsets":["latin"]},{"family":"Yeseva One","variants":["regular"],"subsets":["latin","latin-ext","cyrillic"]},{"family":"Yesteryear","variants":["regular"],"subsets":["latin"]},{"family":"Zeyada","variants":["regular"],"subsets":["latin"]}]';
	const FONT_STRING = 'ABeeZee,Abel,Abril Fatface,Aclonica,Acme,Actor,Adamina,Advent Pro,Aguafina Script,Akronim,Aladin,Aldrich,Alef,Alegreya,Alegreya SC,Alegreya Sans,Alegreya Sans SC,Alex Brush,Alfa Slab One,Alice,Alike,Alike Angular,Allan,Allerta,Allerta Stencil,Allura,Almendra,Almendra Display,Almendra SC,Amarante,Amaranth,Amatic SC,Amethysta,Anaheim,Andada,Andika,Angkor,Annie Use Your Telescope,Anonymous Pro,Antic,Antic Didone,Antic Slab,Anton,Arapey,Arbutus,Arbutus Slab,Architects Daughter,Archivo Black,Archivo Narrow,Arimo,Arizonia,Armata,Artifika,Arvo,Asap,Asset,Astloch,Asul,Atomic Age,Aubrey,Audiowide,Autour One,Average,Average Sans,Averia Gruesa Libre,Averia Libre,Averia Sans Libre,Averia Serif Libre,Bad Script,Balthazar,Bangers,Basic,Battambang,Baumans,Bayon,Belgrano,Belleza,BenchNine,Bentham,Berkshire Swash,Bevan,Bigelow Rules,Bigshot One,Bilbo,Bilbo Swash Caps,Bitter,Black Ops One,Bokor,Bonbon,Boogaloo,Bowlby One,Bowlby One SC,Brawler,Bree Serif,Bubblegum Sans,Bubbler One,Buda,Buenard,Butcherman,Butterfly Kids,Cabin,Cabin Condensed,Cabin Sketch,Caesar Dressing,Cagliostro,Calligraffitti,Cambo,Candal,Cantarell,Cantata One,Cantora One,Capriola,Cardo,Carme,Carrois Gothic,Carrois Gothic SC,Carter One,Caudex,Cedarville Cursive,Ceviche One,Changa One,Chango,Chau Philomene One,Chela One,Chelsea Market,Chenla,Cherry Cream Soda,Cherry Swash,Chewy,Chicle,Chivo,Cinzel,Cinzel Decorative,Clicker Script,Coda,Coda Caption,Codystar,Combo,Comfortaa,Coming Soon,Concert One,Condiment,Content,Contrail One,Convergence,Cookie,Copse,Corben,Courgette,Cousine,Coustard,Covered By Your Grace,Crafty Girls,Creepster,Crete Round,Crimson Text,Croissant One,Crushed,Cuprum,Cutive,Cutive Mono,Damion,Dancing Script,Dangrek,Dawning of a New Day,Days One,Delius,Delius Swash Caps,Delius Unicase,Della Respira,Denk One,Devonshire,Didact Gothic,Diplomata,Diplomata SC,Domine,Donegal One,Doppio One,Dorsa,Dosis,Dr Sugiyama,Droid Sans,Droid Sans Mono,Droid Serif,Duru Sans,Dynalight,EB Garamond,Eagle Lake,Eater,Economica,Ek Mukta,Electrolize,Elsie,Elsie Swash Caps,Emblema One,Emilys Candy,Engagement,Englebert,Enriqueta,Erica One,Esteban,Euphoria Script,Ewert,Exo,Exo 2,Expletus Sans,Fanwood Text,Fascinate,Fascinate Inline,Faster One,Fasthand,Fauna One,Federant,Federo,Felipa,Fenix,Finger Paint,Fira Mono,Fira Sans,Fjalla One,Fjord One,Flamenco,Flavors,Fondamento,Fontdiner Swanky,Forum,Francois One,Freckle Face,Fredericka the Great,Fredoka One,Freehand,Fresca,Frijole,Fruktur,Fugaz One,GFS Didot,GFS Neohellenic,Gabriela,Gafata,Galdeano,Galindo,Gentium Basic,Gentium Book Basic,Geo,Geostar,Geostar Fill,Germania One,Gilda Display,Give You Glory,Glass Antiqua,Glegoo,Gloria Hallelujah,Goblin One,Gochi Hand,Gorditas,Goudy Bookletter 1911,Graduate,Grand Hotel,Gravitas One,Great Vibes,Griffy,Gruppo,Gudea,Habibi,Hammersmith One,Hanalei,Hanalei Fill,Handlee,Hanuman,Happy Monkey,Headland One,Henny Penny,Herr Von Muellerhoff,Holtwood One SC,Homemade Apple,Homenaje,IM Fell DW Pica,IM Fell DW Pica SC,IM Fell Double Pica,IM Fell Double Pica SC,IM Fell English,IM Fell English SC,IM Fell French Canon,IM Fell French Canon SC,IM Fell Great Primer,IM Fell Great Primer SC,Iceberg,Iceland,Imprima,Inconsolata,Inder,Indie Flower,Inika,Irish Grover,Istok Web,Italiana,Italianno,Jacques Francois,Jacques Francois Shadow,Jim Nightshade,Jockey One,Jolly Lodger,Josefin Sans,Josefin Slab,Joti One,Judson,Julee,Julius Sans One,Junge,Jura,Just Another Hand,Just Me Again Down Here,Kameron,Kantumruy,Karla,Kaushan Script,Kavoon,Kdam Thmor,Keania One,Kelly Slab,Kenia,Khmer,Kite One,Knewave,Kotta One,Koulen,Kranky,Kreon,Kristi,Krona One,La Belle Aurore,Lancelot,Lato,League Script,Leckerli One,Ledger,Lekton,Lemon,Libre Baskerville,Life Savers,Lilita One,Lily Script One,Limelight,Linden Hill,Lobster,Lobster Two,Londrina Outline,Londrina Shadow,Londrina Sketch,Londrina Solid,Lora,Love Ya Like A Sister,Loved by the King,Lovers Quarrel,Luckiest Guy,Lusitana,Lustria,Macondo,Macondo Swash Caps,Magra,Maiden Orange,Mako,Marcellus,Marcellus SC,Marck Script,Margarine,Marko One,Marmelad,Marvel,Mate,Mate SC,Maven Pro,McLaren,Meddon,MedievalSharp,Medula One,Megrim,Meie Script,Merienda,Merienda One,Merriweather,Merriweather Sans,Metal,Metal Mania,Metamorphous,Metrophobic,Michroma,Milonga,Miltonian,Miltonian Tattoo,Miniver,Miss Fajardose,Modern Antiqua,Molengo,Molle,Monda,Monofett,Monoton,Monsieur La Doulaise,Montaga,Montez,Montserrat,Montserrat Alternates,Montserrat Subrayada,Moul,Moulpali,Mountains of Christmas,Mouse Memoirs,Mr Bedfort,Mr Dafoe,Mr De Haviland,Mrs Saint Delafield,Mrs Sheppards,Muli,Mystery Quest,Neucha,Neuton,New Rocker,News Cycle,Niconne,Nixie One,Nobile,Nokora,Norican,Nosifer,Nothing You Could Do,Noticia Text,Noto Sans,Noto Serif,Nova Cut,Nova Flat,Nova Mono,Nova Oval,Nova Round,Nova Script,Nova Slim,Nova Square,Numans,Nunito,Odor Mean Chey,Offside,Old Standard TT,Oldenburg,Oleo Script,Oleo Script Swash Caps,Open Sans,Open Sans Condensed,Oranienbaum,Orbitron,Oregano,Orienta,Original Surfer,Oswald,Over the Rainbow,Overlock,Overlock SC,Ovo,Oxygen,Oxygen Mono,PT Mono,PT Sans,PT Sans Caption,PT Sans Narrow,PT Serif,PT Serif Caption,Pacifico,Paprika,Parisienne,Passero One,Passion One,Pathway Gothic One,Patrick Hand,Patrick Hand SC,Patua One,Paytone One,Peralta,Permanent Marker,Petit Formal Script,Petrona,Philosopher,Piedra,Pinyon Script,Pirata One,Plaster,Play,Playball,Playfair Display,Playfair Display SC,Podkova,Poiret One,Poller One,Poly,Pompiere,Pontano Sans,Port Lligat Sans,Port Lligat Slab,Prata,Preahvihear,Press Start 2P,Princess Sofia,Prociono,Prosto One,Puritan,Purple Purse,Quando,Quantico,Quattrocento,Quattrocento Sans,Questrial,Quicksand,Quintessential,Qwigley,Racing Sans One,Radley,Raleway,Raleway Dots,Rambla,Rammetto One,Ranchers,Rancho,Rationale,Redressed,Reenie Beanie,Revalia,Ribeye,Ribeye Marrow,Righteous,Risque,Roboto,Roboto Condensed,Roboto Slab,Rochester,Rock Salt,Rokkitt,Romanesco,Ropa Sans,Rosario,Rosarivo,Rouge Script,Rubik Mono One,Rubik One,Ruda,Rufina,Ruge Boogie,Ruluko,Rum Raisin,Ruslan Display,Russo One,Ruthie,Rye,Sacramento,Sail,Salsa,Sanchez,Sancreek,Sansita One,Sarina,Satisfy,Scada,Schoolbell,Seaweed Script,Sevillana,Seymour One,Shadows Into Light,Shadows Into Light Two,Shanti,Share,Share Tech,Share Tech Mono,Shojumaru,Short Stack,Siemreap,Sigmar One,Signika,Signika Negative,Simonetta,Sintony,Sirin Stencil,Six Caps,Skranji,Slackey,Smokum,Smythe,Sniglet,Snippet,Snowburst One,Sofadi One,Sofia,Sonsie One,Sorts Mill Goudy,Source Code Pro,Source Sans Pro,Source Serif Pro,Special Elite,Spicy Rice,Spinnaker,Spirax,Squada One,Stalemate,Stalinist One,Stardos Stencil,Stint Ultra Condensed,Stint Ultra Expanded,Stoke,Strait,Sue Ellen Francisco,Sunshiney,Supermercado One,Suwannaphum,Swanky and Moo Moo,Syncopate,Tangerine,Taprom,Tauri,Telex,Tenor Sans,Text Me One,The Girl Next Door,Tienne,Tinos,Titan One,Titillium Web,Trade Winds,Trocchi,Trochut,Trykker,Tulpen One,Ubuntu,Ubuntu Condensed,Ubuntu Mono,Ultra,Uncial Antiqua,Underdog,Unica One,UnifrakturCook,UnifrakturMaguntia,Unkempt,Unlock,Unna,VT323,Vampiro One,Varela,Varela Round,Vast Shadow,Vibur,Vidaloka,Viga,Voces,Volkhov,Vollkorn,Voltaire,Waiting for the Sunrise,Wallpoet,Walter Turncoat,Warnes,Wellfleet,Wendy One,Wire One,Yanone Kaffeesatz,Yellowtail,Yeseva One,Yesteryear,Zeyada';

	protected $option = array(
		'type' => Admin_Theme_Menu_Element::TYPE_SELECT,
	);

	function __construct()
	{
		$this->setOptions($this->getFonts());
	}

	/**
	 * Add JS to admin header for displaying font preview
	 */
	function google_font_preview()
	{
		?>
		<script type="text/javascript">

			function change_gfont(el) {
				var saved = '', variants = '', subsets = '', selected = el.find("option:selected");

				saved = jQuery.parseJSON(selected.val());
				variants = jQuery.parseJSON(selected.attr('data-variants'));
				subsets = jQuery.parseJSON(selected.attr('data-subsets'));



				el.parent().parent().find('div.variants').html('');
				jQuery.each(variants, function(index, value) {
					el.parent().parent().find('div.variants').append('<label><input type="checkbox" name="variants" value="' + value + '" />' + value + '</label>');

				});

				el.parent().parent().find('div.subsets').html('');
				jQuery.each(subsets, function(index, value) {
					el.parent().parent().find('div.subsets').append('<label><input type="checkbox" name="subsets" value="' + value + '" />' + value + '</label>');
				});


				jQuery.each(saved[0].variants, function(index, value) {
					el.parent().parent().find('div.variants input').each(function() {
						if (value == jQuery(this).val()) {
							jQuery(this).attr('checked', 'checked');
						}

					});

				});


				jQuery.each(saved[0].subsets, function(index, value) {
					el.parent().parent().find('div.subsets input').each(function() {
						if (value == jQuery(this).val()) {
							jQuery(this).attr('checked', 'checked');
						}

					});

				});


				el.parent().parent().find('div.variants input').click(function() {
					var index = '-1',
							cur_data = jQuery.parseJSON(selected.val());

					if (jQuery(this).prop('checked')) {

						cur_data[0].variants.push(jQuery(this).val());
					} else {

						index = jQuery.inArray(jQuery(this).val(), cur_data[0].variants);
						delete cur_data[0].variants[index];

					}
					selected.val(JSON.stringify(cur_data));

				});


				el.parent().parent().find('div.subsets input').click(function() {
					var index = '-1',
							cur_data = jQuery.parseJSON(selected.val());

					if (jQuery(this).prop('checked')) {

						cur_data[0].subsets.push(jQuery(this).val());
					} else {

						index = jQuery.inArray(jQuery(this).val(), cur_data[0].subsets);
						delete cur_data[0].subsets[index];

					}
					selected.val(JSON.stringify(cur_data));

				});


			}

			jQuery(document).ready(function() {

				jQuery('.gfont').each(function() {

					change_gfont(jQuery(this));

					jQuery(this).on('change keyup keydown', function() {
						change_gfont(jQuery(this));
					});

				});
			});
		</script>
		<?php
	}

	public static function compatibility($value)
	{
		if (substr($value, 0, 1) !== '[')
		{
			$saved = json_decode('[{"family":"' . $value . '","variants":[],"subsets":[]}]', TRUE);
		}
		else
		{

			$saved = json_decode($value, TRUE);
		}

		return $saved;
	}

	public static function font_queue($fonts)
	{
		$queue = $family = '';
		$subsets = array();
		$first = false;
		foreach ($fonts as $font)
		{
			$font = Admin_Theme_Element_Select_Gfont::compatibility($font);
			
			$variants = '';
			if (!$first)
			{
				$family .= $font[0]['family'];
				$first = true;
			}
			else
			{
				$family .= '|' . $font[0]['family'];
			}

			$first_inner = false;
			if ($font[0]['variants'])
			{
				foreach ($font[0]['variants'] as $variant)
				{
					if ($variant)
					{
						if (!$first_inner)
						{
							$variants .= $variant;
							$first_inner = true;
						}
						else
						{
							$variants .= ',' . $variant;
						}
					}
				}

				if ($variants)
				{
					$family .= ':' . $variants;
				}
			}

			if ($font[0]['subsets'])
			{
				foreach ($font[0]['subsets'] as $subset)
				{
					if ($subset)
					{
						$subsets[] = $subset;
					}
				}
			}
		}

		$family = str_replace(' ', '+', $family);

		$queue = $family;
		if ($subsets)
		{
			$queue .= '&amp;subset=' . implode(',', array_unique($subsets));
		}
		return $queue;
	}

	/**
	 * Render select with fonts and addition input with specifying font families and styles
	 * @return string HTML
	 */
	public function render()
	{
		ob_start();
		echo $this->getElementHeader();
		$cur = false;
		?>
		<select  name="<?php echo $this->id; ?>" id="<?php echo $this->id; ?>" class="gfont">
			<?php
			$fonts = json_decode(self::FONT_LIST, TRUE);


			$saved = $this->compatibility(get_option($this->id));

			$saved_subsets = $saved_variants = '';




			foreach ($fonts as $option)
			{
				?>
				<option
				<?php
				$saved_variants = $saved_subsets = '';
				if ($saved[0]['family'] == $option['family'])
				{
					echo ' selected="selected"';
					$cur = true;

					$first = false;

					foreach ($saved[0]['variants'] as $key => $variant)
					{

						if ($variant)
						{
							if (!$first)
							{
								$saved_variants .= '"' . $variant . '"';
								$first = true;
							}
							else
							{
								$saved_variants .= ',"' . $variant . '"';
							}
						}
					}
					$first = false;

					foreach ($saved[0]['subsets'] as $key => $subset)
					{

						if ($subset)
						{
							if (!$first)
							{
								$saved_subsets .= '"' . $subset . '"';
								$first = true;
							}
							else
							{
								$saved_subsets .= ',"' . $subset . '"';
							}
						}
					}
				}
				elseif ($option['family'] == $this->std && !$cur)
				{
					echo ' selected="selected"';
				}
				?>

					data-subsets='<?php
					$subsets = '';
					foreach ($option['subsets'] as $key => $subset)
					{
						if ($key == 0)
						{
							$subsets .= '"' . $subset . '"';
						}
						else
						{
							$subsets .= ',"' . $subset . '"';
						}
					}
					echo '[' . $subsets . ']';
					?>'

					data-variants='<?php
					$variants = '';
					foreach ($option['variants'] as $key => $variant)
					{
						if ($key == 0)
						{
							$variants .= '"' . $variant . '"';
						}
						else
						{
							$variants .= ',"' . $variant . '"';
						}
					}
					echo '[' . $variants . ']';
					?>'

					value='<?php echo '[{"family":"' . $option["family"] . '","variants":[' . $saved_variants . '],"subsets":[' . $saved_subsets . ']}]' ?>'

					>
				<?php echo $option['family']; ?>
				</option>
		<?php } ?>
		</select>
		<span class="label">Font variants:</span>
		<div class='variants'></div>
		<span class="label">Font subsets:</span>
		<div class='subsets'></div>
		<?php
		echo $this->getElementFooter();

		$html = ob_get_clean();
		return $html;
	}

	public function setId($id)
	{
		parent::setId($id);
		add_action('admin_head', array($this, 'google_font_preview'));
		return $this;
	}

	/**
	 * Fonts list
	 * @return array
	 */
	private function getFonts()
	{
		return json_decode(self::FONT_LIST, TRUE);
	}

	public function add_customize_control($wp_customize)
	{
		$wp_customize->add_control($this->getId(), array(
			'label' => $this->getName(),
			'section' => $this->getCustomizeSection(),
			'settings' => $this->getId(),
			'type' => 'select',
			'choices' => $this->getSelectOptionForCustomizing(),
		));
	}

	/**
	 * array of values for WP customizing Select 'value'=>'value'
	 * @return array
	 */
	private function getSelectOptionForCustomizing()
	{
		$result = array();

		if ($this->options && is_array($this->options))
		{
			foreach ($this->options as $option)
			{

				$result['[{"family":"' . $option["family"] . '","variants":["300italic","400italic","600italic","700italic","800italic","400","300","600","700","800"],"subsets":[]}]'] = $option['family'];
			}
		}

		return $result;
	}

}
?>
