<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Word;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Seeds the dictionary content from "Kamus Bergambar Bahasa Indonesia-Tolaki
 * (Edisi Revisi 2022)" by Kantor Bahasa Provinsi Sulawesi Tenggara.
 *
 * Each word entry is [bahasa Indonesia, dialek Konawe, dialek Mekongga].
 */
class CategoryWordSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->data() as $order => $category) {
            $categoryModel = Category::updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'name_tolaki' => $category['name_tolaki'] ?? null,
                    'order' => $order,
                ]
            );

            foreach ($category['words'] as $wordOrder => $word) {
                Word::updateOrCreate(
                    [
                        'category_id' => $categoryModel->id,
                        'word_id' => $word[0],
                    ],
                    [
                        'word_konawe' => $word[1] ?? null,
                        'word_mekongga' => $word[2] ?? null,
                        'order' => $wordOrder,
                    ]
                );
            }
        }
    }

    private function data(): array
    {
        return [
            [
                'name' => 'Angka',
                'name_tolaki' => 'Lamoro',
                'words' => [
                    ['satu', 'oaso', 'aso'],
                    ['dua', 'oruo', 'ruo'],
                    ['tiga', 'otolu', 'tolu'],
                    ['empat', 'oomba', 'omba'],
                    ['lima', 'olimo', 'limo'],
                    ['enam', 'oono', 'ono'],
                    ['tujuh', 'opitu', 'pitu'],
                    ['delapan', 'hoalu', 'hoalo'],
                    ['sembilan', 'osio', 'osio'],
                    ['sepuluh', 'hopulo', 'hapulo'],
                    ['sebelas', 'hopulo aso', 'hopulo aso'],
                    ['dua puluh', 'ruo mbulo', 'ruombulo'],
                    ['tiga puluh', 'tolu mbulo', 'tolombulo'],
                    ['empat puluh', 'pato mbulo', 'patombulo'],
                    ['lima puluh', 'lima mbulo', 'limombulo'],
                    ['enam puluh', 'onoma mbulo', 'nomambulo'],
                    ['tujuh puluh', 'pitu mbulo', 'pitumbolu'],
                    ['delapan puluh', 'halu mbulo', 'halu mbulo'],
                    ['sembilan puluh', 'sio mbulo', 'sio mbulo'],
                    ['seratus', 'asoetu', 'asoetu'],
                    ['seribu', 'sowu', 'sowu'],
                    ['lima ribu', 'limo sowu', 'limo sowu'],
                ],
            ],
            [
                'name' => 'Warna',
                'name_tolaki' => 'Bari / Parada',
                'words' => [
                    ['merah', 'momea', 'momea'],
                    ['kuning', 'mokuni', 'mouso'],
                    ['hijau', 'mololo', 'motai'],
                    ['biru', 'motai', 'motai'],
                    ['putih', 'mowila', 'mopute'],
                    ['oranye', "o'oranye", 'oranye'],
                    ['hitam', 'meeto', 'meeto'],
                    ['ungu', 'wulele orodu', 'oungu'],
                    ['cokelat', 'sokola', 'sokola'],
                ],
            ],
            [
                'name' => 'Sayur-Mayur',
                'name_tolaki' => 'Purundawa',
                'words' => [
                    ['wortel', 'worotele', 'worotele'],
                    ['kentang', 'lamelame', 'oketa'],
                    ['bayam', 'tolembo', 'tolembo'],
                    ['kangkung', 'tarenda', 'tarenda'],
                    ['sawi', 'osawi', 'osawi'],
                    ['cabai', 'osaha', 'olada'],
                    ['okra', 'kopigandu', 'kopigandu'],
                    ['binahong', 'tandalota', 'tandalota'],
                    ['terung', 'palola', 'palola'],
                    ['kelor', 'keloro', 'keloro'],
                    ['kol', 'kolu', 'koolo'],
                    ['daun kedongdong hutan', 'tawaoloho', 'tawaoloho'],
                ],
            ],
            [
                'name' => 'Buah-Buahan',
                'name_tolaki' => 'Wuahako',
                'words' => [
                    ['jeruk', 'omunde', 'olemo'],
                    ['mangga', 'taipa', 'taipa'],
                    ['pisang', 'pundi', 'pundi'],
                    ['durian', 'duria', 'duria'],
                    ['anggur', 'angguru', 'anggoro'],
                    ['jambu', 'odambu', 'dambu'],
                    ['nangka', 'onangga', 'nangga'],
                    ['jambu monyet', 'dambusera', 'dambusera'],
                    ['sukun', 'obaka', 'baka'],
                    ['duwet', 'ruruhi', 'ruruhi'],
                    ['salak', 'wua sala', 'wua sala'],
                    ['tebu', 'otowu', 'towu'],
                    ['kelapa', 'kaluku', 'onii'],
                    ['nanas', 'nanasi', 'opanda'],
                    ['mentimun', 'suai', 'suai'],
                    ['kersen', 'gerese', 'gerese'],
                    ['pepaya', 'kapaya', 'kapaea'],
                    ['semangka', 'ranoa', 'konduri'],
                ],
            ],
            [
                'name' => 'Bagian-Bagian Rumah Adat',
                'name_tolaki' => "Koa-koano Laika Mbu'u",
                'words' => [
                    ['rumah', 'laika', 'laika'],
                    ['atap', "o'ato", "o'ato"],
                    ['pintu', 'otambo', 'tambo'],
                    ['jendela', 'lomba lomba', 'lomba lomba'],
                    ['tiang', 'tusa', 'tusa'],
                    ['tangga', "la'usa", "la'usa"],
                    ['dinding', 'orini', 'orini'],
                ],
            ],
            [
                'name' => 'Perabotan Rumah Tangga',
                'name_tolaki' => 'Pakakasa i Laika',
                'words' => [
                    ['ranjang', 'pandasa', 'koi'],
                    ['bantal', 'paalua', 'paalua'],
                    ['sprei', 'lasari mboisoa', 'palambahi'],
                    ['selimut', 'simbawu', 'holiwu'],
                    ['lemari', 'lamari', 'lamari'],
                    ['kursi', 'kadera', 'kadera'],
                    ['kasur', 'kasoro', 'kasoro'],
                    ['tikar', 'ambahi', 'ambahi'],
                    ['meja', 'omeda', 'meda'],
                ],
            ],
            [
                'name' => 'Rumah Ibadah',
                'name_tolaki' => "Laika Pesambahea'a",
                'words' => [
                    ['pura', 'pure', 'opura'],
                    ['mesjid', 'masigi', 'masigi'],
                    ['klenteng', 'kalente', 'kalente'],
                    ['wihara', 'wihara', 'bihara'],
                    ['gereja', 'gareda', 'gereja'],
                ],
            ],
            [
                'name' => 'Peralatan Rumah Tangga dan Pertukangan',
                'name_tolaki' => "Pakakasa Laika Ronga Ponduka'a",
                'words' => [
                    ['golok', 'ogolo', 'otobo'],
                    ['sabit', 'saira', 'saira'],
                    ['garpu', 'sorangga siru', 'sorangga'],
                    ['sendok', 'osiru', 'siru'],
                    ['piring', 'opingga', 'pingga'],
                    ['gelas', 'otonde', 'tonde'],
                    ['wajan', 'kawali', 'kawali'],
                    ['panci', 'kuro', 'kuro'],
                    ['tungku', "o'polu", "o'dapo"],
                    ['kompor', 'komporo', 'komporo'],
                    ['ketam', 'hatamu', "o'kata"],
                    ['palu', 'palupalu', 'palupalu'],
                    ['pasak kayu', 'pondala', 'pondala'],
                    ['parang', 'pade', 'pade'],
                    ['gergaji', 'garagadi', 'gorogadi'],
                    ['cangkul', 'tanggali', 'winggu'],
                    ['sapu', 'osapu', 'sikuti'],
                ],
            ],
            [
                'name' => 'Alat Penangkap Ikan',
                'name_tolaki' => "Pakakasano Moalo O'ika",
                'words' => [
                    ['tombak ikan', 'kasai', 'duruka'],
                    ['panah ikan', "o'pidi", "o'pidi"],
                    ['jala', 'buani', "o'dala"],
                    ['pancing', 'tonduru', "o'kabi"],
                    ['bubu', 'wuwu', 'wuwu'],
                    ['pukat', "o'puka", "o'puka"],
                ],
            ],
            [
                'name' => 'Hewan Ternak',
                'name_tolaki' => 'Kolele Pineaka',
                'words' => [
                    ['ayam', 'omanu', 'manu'],
                    ['babi', 'obeke', 'beke'],
                    ['angsa', 'ogasa', 'asa'],
                    ['sapi', 'osapi', 'osapi'],
                    ['kambing', 'owembe', 'obee'],
                    ['kuda', 'odara', 'odara'],
                    ['unta', 'ounda', 'outa'],
                    ['bebek', 'obebe', 'manila'],
                    ['ayam hutan', 'manu kasu', 'manukasu'],
                    ['ikan lele', 'koekoetu', 'koetu'],
                    ['belut', 'owiku', 'wiku'],
                ],
            ],
            [
                'name' => 'Hewan Laut',
                'name_tolaki' => 'Kolele i Tahi',
                'words' => [
                    ['ikan teri', 'lure', 'lure'],
                    ['udang', 'ura', 'ura'],
                    ['ikan', 'oika', 'wete'],
                    ['kepiting', 'bungga', 'bungga'],
                    ['buaya', 'bokeo', 'bokeo'],
                    ['penyu', 'oponu', 'oponu'],
                    ['cumi', 'koropunda', "o'tumi"],
                    ['kura-kura', 'kolopua', 'kolopua'],
                    ['siput laut', 'burungo', 'burungo'],
                    ['bintang laut', 'rangga-rangga ndahi', 'taripa'],
                    ['kuda laut', 'dara ndahi', 'dara ndahi'],
                    ['ikan pari', 'paki', "o'pari"],
                    ['ubur-ubur', 'bana-bana', 'bana-bana'],
                    ['ikan hiu', 'hiu', 'hiu'],
                    ['lumba-lumba', 'lombu-lombu', 'lombu-lombu'],
                ],
            ],
            [
                'name' => 'Hewan Darat',
                'name_tolaki' => 'Kolele i Wuta',
                'words' => [
                    ['biawak', 'uti', 'uti'],
                    ['anjing', 'dahu', 'dahu'],
                    ['burung rajawali', 'kongga', 'kongga'],
                    ['burung bangau', 'okoe', 'koe'],
                    ['kecoa', 'sombouo', 'ipo'],
                    ['cacing', 'lodo-lodo', 'lodo-lodo'],
                    ['semut hitam', 'kooheo meeto', 'tanggala'],
                    ['semut merah', 'soleo', 'sooleo'],
                    ['ulat', 'oule', 'ule'],
                    ['lipan', 'olipa', 'ngisimbrere'],
                    ['lalat', 'olale', 'olale'],
                    ['tikus', 'otehu', 'doeke'],
                    ['katak', 'obusi, otunde', 'obusi'],
                    ['ular', 'osao', 'osao'],
                    ['burung nuri', 'kuluri', 'kuluri'],
                    ['kijang', 'odonga', 'ponga'],
                    ['kucing', 'obeka', 'omeo'],
                    ['anoa', 'kadue', 'kadue'],
                    ['monyet', 'ohada', 'hada'],
                ],
            ],
            [
                'name' => 'Profesi',
                'name_tolaki' => 'Tinoriakono',
                'words' => [
                    ['petani', 'patani', 'patani'],
                    ['sopir', 'polelenga', 'sapiri'],
                    ['pilot', "o'pilo", "o'pilo"],
                    ['dokter', 'dootere', 'dootoro'],
                    ['tentara', 'sorodadu', 'sorodadu'],
                    ['nelayan', 'patahi', 'nalaya'],
                    ['juru bicara adat', 'tolea pabitara', 'tolea pabitara'],
                    ['guru', 'tuangguru', 'oguru'],
                ],
            ],
            [
                'name' => 'Bagian-Bagian Tubuh',
                'name_tolaki' => 'Koa-koano Wotolu',
                'words' => [
                    ['ketiak', "totopa'a", "totopa'a"],
                    ['mata kaki', 'boi-boiku', 'buku lale'],
                    ['bahu', 'obose', 'boje'],
                    ['tengkuk', 'singgolodo', 'pasula'],
                    ['ulu hati', 'ulukombo', 'ulukombo'],
                    ['dada', 'wungguaro', 'wungguaro'],
                    ['pinggul', 'oaa', 'bonggela'],
                    ['kaki', 'kare', 'kare'],
                    ['betis', 'tanggelari', 'tanggelari'],
                    ['perut', 'otia', 'otia'],
                    ['siku', 'ohiku', 'hiku'],
                    ['lutut', 'olutu', 'olutu'],
                    ['pusat', 'opuhe', 'puhe'],
                    ['paha', 'opaa', "pa'a"],
                ],
            ],
            [
                'name' => 'Bagian-Bagian Wajah',
                'name_tolaki' => 'Koa-koano Rai',
                'words' => [
                    ['kepala', 'oulu', 'ulu'],
                    ['rambut', 'owuu', 'wuu'],
                    ['ubun-ubun', 'lombo-lombo', 'lombo-lombo'],
                    ['muka/wajah', 'orai', 'rai'],
                    ['telinga', 'obiri', 'biri'],
                    ['mata', 'omata', 'omata'],
                    ['bibir', 'obibi', 'wuli'],
                    ['mulut', 'opondu', 'pondu'],
                    ['alis', 'okire', 'kire'],
                    ['gigi', 'ongisi', 'ngisi'],
                    ['lidah', 'oelo', 'oelo'],
                    ['pipi', 'kombisi', 'kombisi'],
                    ['janggut', 'odanggo', 'danggo'],
                    ['cambang', 'ogambi', 'gambi'],
                    ['kumis', 'bulutungi', 'wulutungi'],
                    ['hidung', 'enge', 'enge'],
                ],
            ],
            [
                'name' => 'Bagian Tangan dan Kaki',
                'name_tolaki' => 'Wuakae ronga Kare',
                'words' => [
                    ['tangan', 'kae', 'kae'],
                    ['jari tengah', 'kupati', 'dowai'],
                    ['telunjuk', 'kondiso', 'kondiso'],
                    ['jari manis', 'kutea', 'tindano dowai'],
                    ['kelingking', 'dowai', 'ana nggae'],
                    ['ibu jari', 'ina nggae', 'ina nggae'],
                    ['kaki', 'kare', 'kare'],
                    ['telapak kaki', 'pelekare', 'tapa kaki'],
                ],
            ],
            [
                'name' => 'Alat Musik Tradisional',
                'name_tolaki' => "Pakakasano O'musi",
                'words' => [
                    ['gong besar', 'karandu', "taa-tawa o'wose"],
                    ['gong kecil', 'tawa-tawa', "tawa-tawa o'wose"],
                    ['suling', 'wuwuho', "o'suli"],
                    ['gambus', 'gambusu', 'gambusu'],
                    ['gendang', 'kanda', "o'dimba"],
                    ['gendang tanah', 'kanda wuta', 'kanda wuta'],
                    ['alat musik pukul', 'ladolado', 'ladolado'],
                    ['gendang bambu', 'dimba nggowuna', 'dimba nggowuna'],
                    ['alat musik bambu', 'baasi', 'baasi'],
                ],
            ],
            [
                'name' => 'Tarian Tradisional',
                'name_tolaki' => 'Lulo',
                'words' => [
                    ['tari lulo', 'molulo', 'molulo'],
                    ['tari lariangi', 'lulo lariangi', 'lulo lariangi'],
                    ['tari umoara', 'lulo umoara', 'lulo umoara'],
                    ['tari mondotambe', 'lulo mondotambe', 'lulo mondotambe'],
                ],
            ],
            [
                'name' => 'Permainan Rakyat',
                'name_tolaki' => 'Pae-paeno Toonodadio',
                'words' => [
                    ['batu lima', "watu o'limo", "watu o'limo"],
                    ['senapan bambu', 'sadakoro', 'sodokoro'],
                    ['engklek', 'melehere', 'mebele'],
                    ['gatrik', 'mesiku', 'mekaca'],
                    ['egrang', 'metinggo', 'metinggo'],
                    ['egrang batok', 'tinggo ulo', 'metinggo ulo'],
                ],
            ],
            [
                'name' => 'Makanan Khas Tolaki',
                'name_tolaki' => "Kinaa Kondu'umano Ndolaki",
                'words' => [
                    ['sinonggi', 'sinonggi', 'sinonggi'],
                    ['ayam tawaoloho', 'manu tawaoloho', 'manu tawaoloho'],
                    ['kabengga', 'kabengga', 'kare-kare'],
                    ['bagea', 'bagea', 'bagea'],
                    ['nasi lemang', 'kinowu', 'kinowu'],
                ],
            ],
            [
                'name' => 'Olahraga',
                'name_tolaki' => 'Olaraga',
                'words' => [
                    ['sepak bola', 'megolu', 'megolu'],
                    ['berlari', 'lumoloia', 'loloia'],
                    ['berenang', 'lumango', 'lumango'],
                    ['lempar galah', 'mekali mesaku', 'megala'],
                ],
            ],
            [
                'name' => 'Transportasi',
                'name_tolaki' => 'Peulaa',
                'words' => [
                    ['mobil', 'ooto', 'ooto'],
                    ['motor', 'motoro', 'motoro'],
                    ['becak', 'obeca', 'beca'],
                    ['kapal', 'kapala', 'kapala'],
                    ['perahu', 'obangga', 'bangga'],
                    ['kereta api', 'koreta api', 'otoapi'],
                    ['sepeda', 'supeda', 'supeda'],
                    ['dokar', "o'bendi", "o'bendi"],
                    ['pesawat terbang', 'kapala lumaa', 'kapala lumaa'],
                ],
            ],
            [
                'name' => 'Astronomi',
                'name_tolaki' => null,
                'words' => [
                    ['matahari', 'oleo', 'mataoleo'],
                    ['awan', 'ogawu', 'tarusa'],
                    ['bulan', 'owula', 'owula'],
                    ['bintang', 'anawula', 'wotiti'],
                    ['pelangi', "toro'ue", "toro'ue"],
                    ['musim hujan', "wula o'usa", "wotu o'usa"],
                    ['musim kemarau', 'wula oleo', 'wotu oleo'],
                ],
            ],
            [
                'name' => 'Bagian-Bagian Perahu',
                'name_tolaki' => "Koa-koano O'bangga",
                'words' => [
                    ['perahu', "o'bangga", "o'bangga"],
                    ['palang kayu tengah', 'polanggano', 'polanggano'],
                    ['papan bagian samping', 'polanggea', 'polanggea'],
                    ['bagian pinggir atas', 'boloboloa', 'boloboloa'],
                    ['dayung', 'owose', 'owose'],
                    ['bagian depan perahu', 'bolosu', 'bolosu'],
                    ['bagian bawah perahu', 'wulelei', 'wulelei'],
                    ['bagian belakang perahu', 'konea', 'konea'],
                ],
            ],
        ];
    }
}
