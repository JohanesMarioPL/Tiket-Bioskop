<?php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        $movies = [
            [
                'title'            => 'Legally Blonde',
                'description'      => "Elle Woods (Reese Witherspoon) has it all. She is the President of her sorority, a Hawaiian Tropic girl, Miss June in her campus calendar, and, above all, a natural blonde. She dates the cutest fraternity boy on campus and wants nothing more than to be Mrs. Warner Huntington III. But, there is just one thing stopping Warner (Matthew Davis) from popping the question: Elle is too blonde. Growing up across the street from Aaron Spelling might mean something in Los Angeles, California, but nothing to Warner's East-Coast blue blood family. So, when Warner packs up for Harvard Law and reunites with an old sweetheart from prep school, Elle rallies all her resources and gets into Harvard, determined to win him back. But law school is a far cry from the comforts of her poolside and the mall. Elle must wage the battle of her life, for her guy, for herself and for all the blondes who suffer endless indignities everyday.",
                'genre'            => 'Comedy',
                'duration_minutes' => 96,
                'rating_age'       => 'R13',
                'poster_url'       => 'posters/poster_legally-blonde.png',
            ],
            [
                'title'            => 'Cruella',
                'description'      => "Before she becomes Cruella de Vil, teenage Estella has a dream. She wishes to become a fashion designer, having been gifted with talent, innovation, and ambition all in equal measures. But life seems intent on making sure her dreams never come true. Having wound up penniless and orphaned in London at 12, 10 years later Estella runs wild through the city streets with her best friends and partners-in-(petty)-crime, Horace and Jasper, two amateur thieves. When a chance encounter vaults Estella into the world of the young rich and famous, however, she begins to question the existence she's built for herself in London and wonders whether she might, indeed, be destined for more after all.",
                'genre'            => 'Drama',
                'duration_minutes' => 134,
                'rating_age'       => 'R13',
                'poster_url'       => 'posters/poster_cruella.jpg',
            ],
            [
                'title'            => 'Exhuma',
                'description'      => "Renowned Korean shaman and her protégé, Hwa-rim (Kim Go-eun) and Bong-gil (Lee Do-hyun) are enlisted by a wealthy Korean American family to identify the mysterious illness of the family's newborn son. Hwa-rim uncovers the curse to be a 'Grave's Call', a vengeful ancestor's spirit haunting them. The family's patriarch, Park Ji-yong, entrust them to relocate the grave to appease the ancestor, his grandfather. Hwa-rim enlists colleagues, a Feng shui master Kim Sang-deok (Choi Min-sik) and a mortician Yeong-geun (Yoo Hae-jin).",
                'genre'            => 'Horror',
                'duration_minutes' => 134,
                'rating_age'       => 'R17',
                'poster_url'       => 'posters/poster_exhuma.webp',
            ],
            [
                'title'            => 'Tinggal Meninggal',
                'description'      => 'Ketika ayahnya meninggal, Gema (Omara Esteghlal), seorang pemuda canggung terkejut saat mendapatkan perhatian dari teman-teman kantornya. Ketika kehangatan itu hilang dan keadaan kembali dingin seperti semula, ia mulai berpikir: siapa lagi yang harus meninggal? Maka mulailah rangkaian kebohongan yang semakin lama semakin membawa kekacauan.',
                'genre'            => 'Comedy',
                'duration_minutes' => 100,
                'rating_age'       => 'R13',
                'poster_url'       => 'posters/poster_tinggal-meninggal.jpg',
            ],
            [
                'title'            => 'Na Willa',
                'description'      => 'Willa (Luisa Adreena), gadis enam tahun yang percaya dunia kecilnya di sebuah gang di Surabaya adalah tempat paling sempurna dan magis. Tempat di mana lagu dari radio terasa hidup, kios langganan yang selalu penuh kejutan, dan setiap hari adalah hari untuk bertualang bersama teman-temannya. Namun ketika sahabatnya mengalami kecelakaan dan satu per satu teman bermainnya mulai masuk sekolah, dunia Willa perlahan berubah dan terasa semakin sepi. Willa pun bertekad mengikuti teman-temannya ke bangku TK, dengan harapan semua bisa kembali seperti semula. Masuk sekolah justru membuka dunia baru yang terasa asing: penuh aturan, batasan, dan rasa tidak dimengerti. Di sanalah Willa perlahan belajar bahwa tumbuh berarti berdamai dengan perubahan. Bahwa keajaiban tidak selalu hilang hanya berpindah tempat.',
                'genre'            => 'Drama',
                'duration_minutes' => 118,
                'rating_age'       => 'SU',
                'poster_url'       => 'posters/poster_na-willa.jpg',
            ],
            [
                'title'            => "Dr. Seuss' the Lorax",
                'description'      => "In the walled city of Thneed-Ville, where everything is artificial and even the air is a commodity, a boy named Ted hopes to win the heart of his dream girl, Audrey. When he learns of her wish to see a real tree, Ted seeks out the Once-ler, a ruined old businessman outside of town in a stark wasteland. Upon hearing of how the hermit gave into his greed for profits and devastated the land over the protests of the Lorax, Ted is inspired to undo the disaster. However, the greedy Mayor of Thneed-Ville, Aloysius O'Hare, has made his fortune exploiting the environmental collapse and is determined to stop the boy from undermining his business.",
                'genre'            => 'Comedy',
                'duration_minutes' => 86,
                'rating_age'       => 'SU',
                'poster_url'       => 'posters/poster_lorax.jpg',
            ],
            [
                'title'            => 'Wonka',
                'description'      => 'Willy Wonka is the mastermind behind some of the most delicious and innovative chocolate creations the world has ever seen. But before shaking up the chocolate industry and making a name for himself as a confectionery genius, the ambitious young creator had to defy all odds. As a result, Willy transformed his wildest dreams into reality with a bold vision, determination, and unexpected help from new friends. After all, hard work and a dash of magic can make anything happen. Because, as Willy already knows, it only takes a dream to make a difference.',
                'genre'            => 'Musical',
                'duration_minutes' => 116,
                'rating_age'       => 'SU',
                'poster_url'       => 'posters/poster_wonka.jpg',
            ],
            [
                'title'            => 'Wicked',
                'description'      => 'In the wondrous Land of Oz, Elphaba, a misunderstood young woman ridiculed for her green skin, and Galinda, the blonde Queen of Popularity at Shiz University, have yet to find their purpose. But life is a series of unplanned and unexpected events. Determined to make their mark in the magical community, the two ambitious students get off on the wrong foot until a pivotal encounter with the enigmatic Wizard of Oz opens their eyes. Now thrust into the public eye, two fledgling witches on their path to greatness stand at a crossroads--one road leads to the light, the other to darkness.',
                'genre'            => 'Musical',
                'duration_minutes' => 160,
                'rating_age'       => 'SU',
                'poster_url'       => 'posters/poster_wicked.png',
            ],
            [
                'title'            => 'The Book of Life',
                'description'      => 'Mary Beth, a museum tour guide, takes a group of school detention students on a secret museum tour, telling them, with wooden figures, the story of a Mexican town called San Angel from the Book of Life, holding every story in the world. On the Day of the Dead, La Muerte, ruler of the Land of the Remembered, and Xibalba, ruler of the Land of the Forgotten, see Manolo Sánchez and Joaquín Mondragon competing over María Posada. They strike a wager: if María marries Manolo, Xibalba will no longer interfere in mortal affairs, but if she marries Joaquín, La Muerte and Xibalba will swap realms. However, Xibalba cheats by giving Joaquín his Medal of Everlasting Life, which grants the wearer invincibility.',
                'genre'            => 'Fantasy',
                'duration_minutes' => 95,
                'rating_age'       => 'SU',
                'poster_url'       => 'posters/poster_tbol.jpeg',
            ],
            [
                'title'            => 'Barbie',
                'description'      => 'In the vibrant, seemingly perfect world of Barbieland, Barbie lives a life of constant celebration. However, when she begins to experience a sudden existential crisis that disrupts her daily routine, she is forced to confront the limitations of her reality. Seeking answers, Barbie embarks on a journey to the Real World, accompanied by the perpetually adoring Ken. As they navigate the complexities of life among humans, the two discover unexpected truths about themselves, their purpose, and the nature of their relationship, forcing them to re-evaluate everything they once understood about their existence.',
                'genre'            => 'Comedy',
                'duration_minutes' => 114,
                'rating_age'       => 'R13',
                'poster_url'       => 'posters/poster_barbie.jpg',
            ],
            [
                'title'            => 'Spider-Man: Across the Spider-Verse',
                'description'      => "Miles Morales returns for the next chapter of the Oscar®-winning Spider-Verse saga, an epic adventure that will transport Brooklyn's full-time, friendly neighborhood Spider-Man across the Multiverse to join forces with Gwen Stacy and a new team of Spider-People to face off with a villain more powerful than anything they have ever encountered.",
                'genre'            => 'Action',
                'duration_minutes' => 140,
                'rating_age'       => 'SU',
                'poster_url'       => 'posters/poster_spiderman.jpeg',
            ],
        ];

        foreach ($movies as $movie) {
            Movie::create($movie);
        }
    }
}
