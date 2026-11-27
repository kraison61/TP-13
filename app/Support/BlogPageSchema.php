<?php

namespace App\Support;

use App\Models\Blog;

class BlogPageSchema
{
    public static function graph(Blog $blog): array
    {
        $base = OrganizationSchema::baseUrl();
        $blogUrl = route('blog.show', $blog->slug);

        $graph = [
            self::author($base),
            self::webPage($blog, $blogUrl),
            self::blogPosting($blog, $blogUrl, $base),
            self::breadcrumbList($blog, $blogUrl, $base),
        ];

        if ($blog->slug === 'solar-cell-installation-price') {
            $graph[] = self::solarPriceGuideFaqPage();
        }

        if ($blog->slug === 'solar-cell-10kw-production-price') {
            $graph[] = self::solar10kwFaqPage();
        }

        if ($blog->slug === 'home-solar-cell-price-guide') {
            $graph[] = self::homeSolarCellPriceGuideFaqPage();
        }

        if ($blog->slug === 'short-circuit-house-fire') {
            $graph[] = self::shortCircuitHouseFireFaqPage();
        }

        if ($blog->slug === 'ground-rod-installation-home') {
            $graph[] = self::groundRodInstallationHomeFaqPage();
            $graph[] = self::groundRodInstallationHomeHowTo();
        }

        if ($blog->slug === 'big-tree-cutting-price') {
            $graph[] = self::bigTreeCuttingPriceFaqPage();
            $graph[] = self::bigTreeCuttingPriceHowTo();
        }

        if ($blog->slug === 'tree-cutting-service-root-removal') {
            $graph[] = self::treeCuttingServiceRootRemovalFaqPage();
            $graph[] = self::treeCuttingServiceRootRemovalService($blogUrl);
        }

        if ($blog->slug === 'junk-removal-nonthaburi') {
            $graph[] = self::junkRemovalNonthaburiFaqPage();
            $graph[] = self::junkRemovalNonthaburiService($blogUrl);
        }

        return [
            '@context' => 'https://schema.org',
            '@graph' => $graph,
        ];
    }

    private static function author(string $base): array
    {
        return [
            '@type' => 'Person',
            '@id' => "{$base}/#author",
            'name' => 'ช่างรัก (Mr.Theeraphong Sarsuk)',
            'jobTitle' => 'ผู้เชี่ยวชาญด้านงานก่อสร้าง',
            'url' => route('about-us'),
            'worksFor' => OrganizationSchema::reference(),
            'knowsAbout' => [
                'รับเหมาก่อสร้างกำแพงกันดิน',
                'รับสร้างรั้วบ้าน',
                'งานโยธา',
            ],
        ];
    }

    private static function webPage(Blog $blog, string $blogUrl): array
    {
        return [
            '@type' => 'WebPage',
            '@id' => "{$blogUrl}#webpage",
            'url' => $blogUrl,
            'name' => $blog->title,
            'inLanguage' => self::language($blog),
        ];
    }

    private static function blogPosting(Blog $blog, string $blogUrl, string $base): array
    {
        $node = [
            '@type' => 'BlogPosting',
            '@id' => "{$blogUrl}#article",
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => "{$blogUrl}#webpage",
            ],
            'headline' => $blog->title,
            'description' => $blog->description,
            'author' => [
                '@type' => 'Person',
                '@id' => "{$base}/#author",
            ],
            'publisher' => OrganizationSchema::reference(),
            'datePublished' => $blog->created_at
                ->setTimezone('Asia/Bangkok')
                ->toIso8601String(),
            'dateModified' => $blog->updated_at
                ->setTimezone('Asia/Bangkok')
                ->toIso8601String(),
            'inLanguage' => self::language($blog),
            'wordCount' => self::wordCount($blog),
            'keywords' => self::keywords($blog),
        ];

        $images = BlogImageVariants::schemaImageObjects($blog->cover_image);
        if ($images !== []) {
            $node['image'] = $images;
        }

        if ($blog->relationLoaded('service') && $blog->service?->relationLoaded('category')) {
            $section = $blog->service->category?->name;
            if ($section) {
                $node['articleSection'] = $section;
            }
        }

        if ($blog->slug === 'solar-cell-installation-price') {
            $node['about'] = [
                ['@type' => 'Thing', 'name' => 'ราคาติดตั้งโซล่าเซลล์'],
                ['@type' => 'Thing', 'name' => 'Solar Rooftop'],
                ['@type' => 'Thing', 'name' => 'การเปรียบเทียบใบเสนอราคา'],
            ];
            $node['citation'] = [
                '@type' => 'WebPage',
                'name' => 'ตารางราคาติดตั้งโซล่าเซลล์ทุกรุ่น พร้อม VAT โดย BOA-BuildTech',
                'url' => 'https://www.boabuildtech.com/services/mechanical-and-electrical-work/electrical/solar-cell-installation',
            ];
            $node['keywords'] = 'ติดโซล่าเซลล์ ราคา, โซล่าเซลล์ 5kW ราคา, ราคาติดโซล่าเซลล์, ราคาติดโซล่าเซลล์บ้าน';
        }

        if ($blog->slug === 'solar-cell-10kw-production-price') {
            $node['about'] = [
                ['@type' => 'Thing', 'name' => 'โซล่าเซลล์ 10kW'],
                ['@type' => 'Thing', 'name' => 'หน่วยไฟที่ผลิตได้'],
                ['@type' => 'Thing', 'name' => 'ราคาติดตั้งโซล่าเซลล์'],
            ];
            $node['citation'] = [
                '@type' => 'WebPage',
                'name' => 'ตารางราคาติดตั้งโซล่าเซลล์ทุกรุ่น พร้อม VAT โดย BOA-BuildTech',
                'url' => 'https://www.boabuildtech.com/services/mechanical-and-electrical-work/electrical/solar-cell-installation',
            ];
            $node['keywords'] = 'โซล่าเซลล์ 10kw ผลิตไฟได้กี่หน่วย, โซล่าเซลล์ 10kw ราคา, ราคาโซล่าเซลล์ 10kw, ติดตั้งโซล่าเซลล์ 10kw ราคา, โซล่าเซลล์ออฟกริด 10kw ราคา, โซล่าเซลล์ 10kw ใช้อะไรได้บ้าง';
        }

        if ($blog->slug === 'home-solar-cell-price-guide') {
            $node['about'] = [
                ['@type' => 'Thing', 'name' => 'บ้านโซล่าเซลล์'],
                ['@type' => 'Thing', 'name' => 'ราคาติดตั้งโซล่าเซลล์บ้าน'],
                ['@type' => 'Thing', 'name' => 'เลือกขนาดโซล่าเซลล์'],
            ];
            $node['citation'] = [
                '@type' => 'WebPage',
                'name' => 'ตารางราคาติดตั้งโซล่าเซลล์ทุกรุ่น พร้อม VAT โดย BOA-BuildTech',
                'url' => 'https://www.boabuildtech.com/services/mechanical-and-electrical-work/electrical/solar-cell-installation',
            ];
            $node['keywords'] = 'บ้านโซล่าเซลล์, ราคาติดตั้งโซล่าเซลล์บ้าน, ติดโซล่าเซลล์ 5kw ราคา, โซล่าเซลล์สำหรับบ้าน 1 หลัง, ติดโซล่าเซลล์ 3kw ราคา, ติดโซล่าเซลล์บ้านแบบไหนดี, ติดโซล่าเซลล์ 5000w ราคาถูก, โซล่าเซลล์พร้อมแบตเตอรี่ ราคา';
        }

        if ($blog->slug === 'micro-pile-for-large-project') {
            $node['about'] = [
                ['@type' => 'Thing', 'name' => 'เสาเข็มไมโครไพล์'],
                ['@type' => 'Thing', 'name' => 'งานต่อเติมโรงงาน'],
                ['@type' => 'Thing', 'name' => 'เสาเข็มไมโครไพล์ I18'],
                ['@type' => 'Thing', 'name' => 'เสาเข็มไมโครไพล์ I22'],
            ];
            $node['citation'] = [
                '@type' => 'WebPage',
                'name' => 'ราคาเสาเข็มไอและเสาเข็มสี่เหลี่ยมตัน อัปเดต ก.ย. 2569',
                'url' => 'https://www.boabuildtech.com/services/civil/piles-foundation',
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => 'BOA-Buildtech',
                ],
            ];
            $node['keywords'] = 'เสาเข็มไมโครไพล์, เสาเข็มไมโครไพล์ I18, เสาเข็มไมโครไพล์ I22, เสาเข็มไมโครไพล์ ราคา, กดเสาเข็มโรงงาน, ต่อเติมโรงงาน';
        }

        if ($blog->slug === 'short-circuit-house-fire') {
            $node['about'] = [
                ['@type' => 'Thing', 'name' => 'ไฟฟ้าลัดวงจร'],
                ['@type' => 'Thing', 'name' => 'ไฟไหม้บ้าน'],
                ['@type' => 'Thing', 'name' => 'ความปลอดภัยระบบไฟฟ้า'],
            ];
            $node['citation'] = [
                [
                    '@type' => 'WebPage',
                    'name' => 'กทม. เปิดสถิติไฟไหม้ย้อนหลัง 3 ปี',
                    'url' => 'https://www.matichon.co.th/local/news_5515636',
                ],
                [
                    '@type' => 'WebPage',
                    'name' => 'ทวิดาเตือนไฟฟ้าลัดวงจรพุ่งช่วงน้ำท่วม',
                    'url' => 'https://www.matichon.co.th/local/news_5910029',
                ],
            ];
            $node['keywords'] = 'ไฟฟ้าลัดวงจร, ไฟไหม้บ้านเกิดจากอะไร, สายไฟเก่า, ปลั๊กพ่วง มอก., เบรกเกอร์ตัดบ่อย, ตรวจระบบไฟฟ้าในบ้าน';
        }

        if ($blog->slug === 'ground-rod-installation-home') {
            $node['about'] = [
                ['@type' => 'Thing', 'name' => 'ตอกแท่งกราวด์ในบ้าน'],
                ['@type' => 'Thing', 'name' => 'ติดตั้งสายดิน'],
                ['@type' => 'Thing', 'name' => 'ตอกกราวด์แบบเดลต้า'],
            ];
            $node['citation'] = [
                [
                    '@type' => 'WebPage',
                    'name' => 'งานติดตั้งสายดิน พหลโยธิน 24',
                    'url' => 'https://www.boabuildtech.com/works/ground-rod-installation-phahonyothin-24',
                ],
            ];
            $node['keywords'] = 'ตอกแท่งกราวด์ในบ้าน, วิธีต่อสายกราวด์ไฟบ้าน, วิธีการตอกกราวด์แบบเดลต้า, วิธีต่อสายกราวด์ตู้คอนซูมเมอร์, ติดตั้งสายดินราคา';
        }

        if ($blog->slug === 'big-tree-cutting-price') {
            $node['about'] = [
                ['@type' => 'Thing', 'name' => 'ตัดต้นไม้ใหญ่ ราคา'],
                ['@type' => 'Thing', 'name' => 'รับจ้างตัดต้นไม้ใหญ่'],
                ['@type' => 'Thing', 'name' => 'ขุดตอต้นไม้'],
            ];
            $node['keywords'] = 'ตัดต้นไม้ใหญ่ ราคา, รับจ้างตัดต้นไม้ใหญ่ ราคา, รับตัดต้นไม้ใหญ่ ราคา, ราคาค่าตัดต้นไม้ใหญ่, ราคาตัดต้นไม้ใหญ่';
        }

        if ($blog->slug === 'tree-cutting-service-root-removal') {
            $node['about'] = [
                ['@type' => 'Thing', 'name' => 'Tree felling'],
                ['@type' => 'Thing', 'name' => 'Stump and root removal'],
            ];
            $node['keywords'] = 'tree cutting service, tree felling, tree trimming, root removal';
        }

        if ($blog->slug === 'junk-removal-nonthaburi') {
            $node['about'] = [
                ['@type' => 'Thing', 'name' => 'รับจ้างขนขยะไปทิ้ง'],
                ['@type' => 'Thing', 'name' => 'เคลียร์ของเก่าเก็บ'],
                ['@type' => 'Thing', 'name' => 'ขนขยะ นนทบุรี'],
            ];
            $node['keywords'] = 'รับจ้างขนขยะไปทิ้ง, รับขนขยะ, รับจ้างขนขยะ, ขนขยะไปทิ้ง, รถรับจ้างขนขยะ, ขนของเก่าไปทิ้ง, ขนขยะ นนทบุรี';
        }

        return $node;
    }

    /**
     * FAQ answers must match on-page FAQ text exactly (SEO package).
     *
     * @return array<string, mixed>
     */
    private static function solarPriceGuideFaqPage(): array
    {
        $faqs = [
            [
                'q' => 'ติดโซล่าเซลล์ ราคาคิดจากอะไร',
                'a' => 'ราคาระบบโซล่าเซลล์ประกอบด้วยต้นทุน 5 ก้อน คือ แผงโซล่าเซลล์ประมาณ 30 ถึง 40 เปอร์เซ็นต์ อินเวอร์เตอร์ประมาณ 20 ถึง 30 เปอร์เซ็นต์ โครงสร้างยึดและอุปกรณ์ไฟฟ้าประมาณ 10 ถึง 15 เปอร์เซ็นต์ ค่าแรงติดตั้งประมาณ 10 ถึง 20 เปอร์เซ็นต์ และค่าดำเนินการเอกสารขออนุญาตประมาณ 5 ถึง 10 เปอร์เซ็นต์ สองเจ้าที่เสนอขนาดเท่ากันจึงมีราคาต่างกันได้ตามสเปกอุปกรณ์ ชนิดหลังคา และขอบเขตงานที่รวมอยู่ในราคา',
            ],
            [
                'q' => 'โซล่าเซลล์ 5kW ราคาขึ้นอยู่กับอะไร',
                'a' => 'ขึ้นอยู่กับ 6 ปัจจัยหลัก คือ ระบบไฟเป็น 1 เฟสหรือ 3 เฟส เป็นระบบ On-Grid หรือ Hybrid มีแบตเตอรี่หรือไม่และความจุเท่าไหร่ จำนวนแผงที่ใช้ตามกำลังวัตต์ต่อแผง ระยะรับประกันของแผงและอินเวอร์เตอร์ และราคานั้นรวมค่าดำเนินการขออนุญาตแล้วหรือยัง ระบบ 5 kW เหมาะกับบ้านที่ใช้ไฟ 700 ถึง 1,000 หน่วยต่อเดือน และต้องมีพื้นที่หลังคาว่างประมาณ 25 ถึง 30 ตารางเมตร',
            ],
            [
                'q' => 'ราคาติดโซล่าเซลล์บ้านที่เห็นในโฆษณา รวมทุกอย่างแล้วหรือยัง',
                'a' => 'ส่วนใหญ่เป็นราคาสำหรับหน้างานในอุดมคติ คือหลังคาเมทัลชีท บ้านชั้นเดียว โครงสร้างแข็งแรง ตู้ไฟอยู่ใกล้ และระบบไฟ 1 เฟส สิ่งที่มักไม่รวมคือค่าเสริมโครงสร้างหลังคา ค่าปรับปรุงตู้ไฟและระบบกราวด์ ค่าสายไฟส่วนเกินเมื่อระยะเดินสายไกล ค่าดำเนินการขออนุญาตและค่าธรรมเนียมการไฟฟ้า ค่าเปลี่ยนมิเตอร์ และค่านั่งร้านสำหรับบ้านสูง ควรให้ผู้รับเหมาขึ้นสำรวจหลังคาจริงก่อนออกใบเสนอราคาเสมอ',
            ],
            [
                'q' => 'ใบเสนอราคาโซล่าเซลล์ที่ดีต้องมีอะไรบ้าง',
                'a' => 'ต้องระบุยี่ห้อ รุ่น และกำลังวัตต์ของแผงพร้อมจำนวนแผง ยี่ห้อและรุ่นของอินเวอร์เตอร์ ระยะรับประกันแยกรายการทั้งแผง อินเวอร์เตอร์ และงานติดตั้ง ชนิดโครงสร้างยึดที่ใช้กับหลังคาแบบของคุณ ระบุชัดว่ารวมค่ายื่นขออนุญาตขนานไฟและรวม VAT แล้วหรือยัง ระยะเวลาส่งมอบ เงื่อนไขการชำระเงินเป็นงวด และขอบเขตงานที่ไม่รวม คำว่าอุปกรณ์มาตรฐานโดยไม่ระบุรุ่นคือสัญญาณที่ควรขอให้ระบุเพิ่ม',
            ],
            [
                'q' => 'เทียบราคาผู้รับเหมาหลายเจ้ายังไงให้เทียบกันได้จริง',
                'a' => 'อย่าเทียบที่ราคารวม ให้คำนวณราคาต่อวัตต์โดยนำราคารวมหารด้วยกำลังติดตั้งเป็นวัตต์ เช่น ระบบ 5 kW คือ 5,000 วัตต์ แล้วเทียบควบคู่กับสเปกอุปกรณ์และขอบเขตงานในตารางเดียวกัน หากราคาต่อวัตต์ต่างกันไม่เกิน 10 เปอร์เซ็นต์ ให้ตัดสินที่ระยะรับประกันงานติดตั้งและความชัดเจนของขอบเขตงานแทน',
            ],
            [
                'q' => 'ราคาถูกกว่าเจ้าอื่นมาก ควรระวังอะไร',
                'a' => 'สัญญาณที่ควรระวังคือ ไม่ระบุยี่ห้อและรุ่นอุปกรณ์ รับประกันเฉพาะอุปกรณ์แต่ไม่รับประกันงานติดตั้งและการรั่วซึม ไม่รวมค่าดำเนินการขออนุญาตขนานไฟ ขอเก็บเงินเกือบเต็มจำนวนก่อนเริ่มงาน และไม่มีนิติบุคคลหรือที่อยู่ที่ตรวจสอบได้ ระบบที่ติดตั้งโดยไม่ขออนุญาตกับการไฟฟ้ามีความเสี่ยงทั้งด้านความปลอดภัย ด้านกฎหมาย และปัญหาตอนขายบ้านต่อ',
            ],
            [
                'q' => 'คำนวณระยะคืนทุนเองยังไง',
                'a' => 'นำราคาระบบทั้งหมดหารด้วยเงินที่ประหยัดได้ต่อปี โดยเงินที่ประหยัดได้ต่อปีคือหน่วยไฟที่ใช้จริงต่อเดือนคูณค่าไฟต่อหน่วยคูณ 12 จุดที่คนคำนวณผิดบ่อยที่สุดคือหน่วยที่ผลิตได้ไม่เท่ากับหน่วยที่ประหยัดได้ เพราะระบบ On-Grid ที่ผลิตไฟตอนกลางวันแต่ไม่มีใครใช้ ไฟส่วนเกินจะไหลทิ้งไปหากไม่ได้เข้าโครงการรับซื้อไฟ สัดส่วนการใช้ไฟกลางวันจึงมีผลต่อระยะคืนทุนมากกว่าขนาดระบบ',
            ],
            [
                'q' => 'ดูราคาติดตั้งโซล่าเซลล์แต่ละขนาดได้ที่ไหน',
                'a' => 'BOA-BuildTech เผยแพร่ตารางราคาติดตั้งโซล่าเซลล์เป็นรายรุ่น ทั้งระบบ On-Grid ระบบ Hybrid และระบบ Hybrid All in One ตั้งแต่ขนาด 3 kW ถึง 20 kW โดยระบุว่าเป็นราคารวมภาษีมูลค่าเพิ่มแล้ว พร้อมเงื่อนไขการผ่อนชำระและระยะรับประกันแยกรายการ สามารถใช้เป็นราคาอ้างอิงเพื่อเทียบกับใบเสนอราคาที่ได้รับมา',
            ],
        ];

        return [
            '@type' => 'FAQPage',
            'mainEntity' => array_map(static fn (array $item): array => [
                '@type' => 'Question',
                'name' => $item['q'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $item['a'],
                ],
            ], $faqs),
        ];
    }

    /**
     * FAQ answers must match on-page FAQ text exactly (SEO package).
     *
     * @return array<string, mixed>
     */
    private static function solar10kwFaqPage(): array
    {
        $faqs = [
            [
                'q' => 'โซล่าเซลล์ 10kW ผลิตไฟได้กี่หน่วยต่อวัน?',
                'a' => 'โซล่าเซลล์ขนาด 10kW ผลิตไฟฟ้าเฉลี่ย 40–60 หน่วยต่อวันในวันที่มีแดดปกติ คิดจากชั่วโมงแดดใช้งานได้จริงในไทยที่ 4.5–5 ชั่วโมงต่อวัน คูณกับประสิทธิภาพระบบโดยรวมประมาณ 80–85% ตัวเลขจริงจะแตกต่างไปตามทิศทางหลังคา เงาบัง และสภาพอากาศแต่ละวัน',
            ],
            [
                'q' => 'โซล่าเซลล์ 10kW ใช้แอร์ได้กี่ตัว?',
                'a' => 'ในช่วงเวลากลางวันที่แดดดี โซล่าเซลล์ 10kW รองรับแอร์ขนาด 12,000–18,000 BTU ได้ประมาณ 3–4 เครื่องเปิดพร้อมกัน พร้อมเครื่องใช้ไฟฟ้าพื้นฐานอื่น เช่น ตู้เย็น เครื่องซักผ้า และทีวี ได้ในเวลาเดียวกัน',
            ],
            [
                'q' => 'ติดตั้งโซล่าเซลล์ 10kW ราคาเท่าไหร่?',
                'a' => 'ระบบออนกริด 10kW แบบ 3 เฟส ราคาประมาณ 297,850 บาทพร้อม VAT ส่วนระบบไฮบริดที่เพิ่มแบตเตอรี่ 10 kWh ราคาจะอยู่ระหว่าง 389,850–573,850 บาท ขึ้นอยู่กับระบบไฟและรูปแบบตู้ควบคุมที่เลือก',
            ],
            [
                'q' => 'โซล่าเซลล์ออฟกริด 10kW ต่างจากไฮบริดยังไง?',
                'a' => 'ออฟกริดแท้ตัดขาดจากสายการไฟฟ้าโดยสิ้นเชิง ต้องใช้แบตเตอรี่ความจุใหญ่กว่าจึงราคาสูงกว่า ส่วนไฮบริดยังเชื่อมต่อกับการไฟฟ้าอยู่ มีแบตเตอรี่สำรองไฟแต่ดึงไฟจากการไฟฟ้ามาใช้ต่อได้หากแบตหมด เหมาะกับบ้านในเขตเมืองมากกว่าและราคาถูกกว่าออฟกริดแท้',
            ],
            [
                'q' => 'บ้านที่ใช้ไฟเดือนละกี่หน่วยควรเลือกขนาด 10kW?',
                'a' => 'บ้านที่ใช้ไฟเดือนละ 1,500–2,000 หน่วย หรือค่าไฟประมาณ 8,000–12,000 บาทต่อเดือน เหมาะกับขนาด 10kW โดยประหยัดค่าไฟได้ประมาณ 4,800–6,000 บาทต่อเดือน และคืนทุนภายใน 4–5 ปี',
            ],
            [
                'q' => 'ติดตั้งโซล่าเซลล์ 10kW ลดหย่อนภาษีได้ไหม?',
                'a' => 'ได้ หากผู้ให้บริการออกใบกำกับภาษีอิเล็กทรอนิกส์ (E-TAX Invoice) ให้ เจ้าของบ้านสามารถใช้สิทธิลดหย่อนภาษีค่าติดตั้งโซล่าเซลล์สำหรับที่อยู่อาศัยได้สูงสุด 200,000 บาทตามเงื่อนไขกรมสรรพากร ควรตรวจสอบเงื่อนไขล่าสุดกับกรมสรรพากรหรือผู้ทำบัญชีก่อนตัดสินใจ',
            ],
        ];

        return [
            '@type' => 'FAQPage',
            'mainEntity' => array_map(static fn (array $item): array => [
                '@type' => 'Question',
                'name' => $item['q'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $item['a'],
                ],
            ], $faqs),
        ];
    }

    /**
     * FAQ answers must match on-page FAQ text exactly (SEO package).
     *
     * @return array<string, mixed>
     */
    private static function homeSolarCellPriceGuideFaqPage(): array
    {
        $faqs = [
            [
                'q' => 'ราคาติดตั้งโซล่าเซลล์บ้านเริ่มต้นเท่าไหร่?',
                'a' => 'ราคาเริ่มต้นประมาณ 142,600 บาทพร้อม VAT สำหรับขนาด 3kW ซึ่งเป็นขนาดเล็กสุดที่นิยมติดตั้งในบ้านพักอาศัย ราคาจะเพิ่มขึ้นตามขนาดระบบและตัวเลือกแบตเตอรี่',
            ],
            [
                'q' => 'ติดโซล่าเซลล์ 3kW ราคาเท่าไหร่?',
                'a' => 'ระบบ 3kW แบบ 1 เฟส ราคาประมาณ 142,600 บาทพร้อม VAT ทั้งแบบออนกริดและไฮบริดที่ยังไม่ใส่แบตเตอรี่ เหมาะกับบ้านที่ใช้ไฟ 400–600 หน่วยต่อเดือน',
            ],
            [
                'q' => 'ติดโซล่าเซลล์ 5kW หรือ 5000W ราคาเท่าไหร่?',
                'a' => 'ราคาอยู่ระหว่าง 154,100–251,850 บาท ขึ้นอยู่กับระบบไฟและแบตเตอรี่ โดยตัวเลือกที่ถูกที่สุดคือระบบไฮบริดแบบ 1 เฟสที่ยังไม่ใส่แบตเตอรี่ ราคา 154,100 บาท',
            ],
            [
                'q' => 'โซล่าเซลล์สำหรับบ้าน 1 หลัง ควรเลือกขนาดเท่าไหร่?',
                'a' => 'ให้ดูจากหน่วยไฟที่ใช้ช่วงกลางวันเป็นหลัก นำหน่วยไฟต่อเดือนหารด้วย 130 จะได้ขนาดระบบโดยประมาณ เช่น ใช้ไฟ 700–1,000 หน่วยต่อเดือน เหมาะกับขนาด 5kW',
            ],
            [
                'q' => 'ติดโซล่าเซลล์บ้านแบบไหนดี ออนกริดหรือไฮบริด?',
                'a' => 'บ้านที่ใช้ไฟหนักกลางวันและมีไฟฟ้าจากการไฟฟ้าอยู่แล้วเหมาะกับออนกริดเพราะราคาถูกกว่าและคืนทุนเร็วกว่า ส่วนบ้านที่ใช้ไฟหนักกลางคืนหรือไฟดับบ่อยเหมาะกับไฮบริดที่มีแบตเตอรี่สำรอง',
            ],
            [
                'q' => 'โซล่าเซลล์พร้อมแบตเตอรี่ราคาเท่าไหร่?',
                'a' => 'ส่วนต่างราคาจากการเพิ่มแบตเตอรี่ 10 kWh อยู่ที่ประมาณ 28,750 บาทขึ้นไปเมื่อเทียบกับระบบไม่มีแบต โดยราคารวมของระบบไฮบริดพร้อมแบตเตอรี่ 10 kWh เริ่มต้นที่ 182,850 บาทสำหรับขนาด 5kW',
            ],
        ];

        return [
            '@type' => 'FAQPage',
            'mainEntity' => array_map(static fn (array $item): array => [
                '@type' => 'Question',
                'name' => $item['q'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $item['a'],
                ],
            ], $faqs),
        ];
    }

    /**
     * FAQ answers must match on-page FAQ text exactly (SEO package).
     *
     * @return array<string, mixed>
     */
    private static function shortCircuitHouseFireFaqPage(): array
    {
        $faqs = [
            [
                'q' => 'ปลั๊กพ่วงแบบไหนปลอดภัยและไม่เสี่ยงไฟไหม้?',
                'a' => 'ปลั๊กพ่วงที่ปลอดภัยต้องมีเครื่องหมาย มอก. 2432-2555 ซึ่งเป็นมาตรฐานบังคับตั้งแต่วันที่ 24 กุมภาพันธ์ 2561 มีเบรกเกอร์ตัดไฟเมื่อใช้กระแสเกินแทนฟิวส์ และตัวรางทำจากวัสดุไม่ลามไฟ ก่อนใช้ให้ดูกำลังไฟสูงสุดบนฉลาก เช่น 10 แอมป์รับได้ราว 2,300 วัตต์ และไม่เสียบปลั๊กพ่วงต่อกันหลายทอด',
            ],
            [
                'q' => 'สายไฟในบ้านมีอายุการใช้งานกี่ปี ควรเปลี่ยนเมื่อไหร่?',
                'a' => 'สายไฟในบ้านโดยทั่วไปใช้งานได้ราว 15–20 ปี ขึ้นกับความร้อน ความชื้น และปริมาณการใช้ไฟ ควรเปลี่ยนทันทีเมื่อฉนวนแข็งกรอบ แตกลาย เปลี่ยนสี หรือมีรอยไหม้ แม้ยังไม่ครบอายุ บ้านที่อายุเกิน 15 ปีและยังไม่เคยเปลี่ยนสายไฟ ควรให้ช่างไฟฟ้าตรวจสภาพสายและจุดต่อทั้งหลัง',
            ],
            [
                'q' => 'เบรกเกอร์ตัดบ่อยเกิดจากอะไร ต้องแก้ไขอย่างไร?',
                'a' => 'เบรกเกอร์ตัดบ่อยมักเกิดจาก 3 เรื่อง คือ ใช้ไฟเกินในวงจรนั้น มีไฟรั่ว หรือมีจุดลัดวงจร เบื้องต้นให้ถอดปลั๊กเครื่องใช้ไฟฟ้าออกทั้งหมด สับเบรกเกอร์ขึ้น แล้วเสียบกลับทีละเครื่องเพื่อหาตัวที่ทำให้ตัด ถ้าถอดหมดแล้วยังตัดหรือสับไม่ขึ้น ห้ามฝืนสับซ้ำ และให้เรียกช่างไฟฟ้ามาตรวจ',
            ],
            [
                'q' => 'ไฟฟ้าลัดวงจรกับไฟรั่วต่างกันอย่างไร?',
                'a' => 'ไฟฟ้าลัดวงจรคือสายที่มีไฟแตะกันโดยตรง กระแสพุ่งสูงมากในเสี้ยววินาทีจนเกิดประกายไฟและเสี่ยงไฟไหม้ ส่วนไฟรั่วคือกระแสไหลออกนอกวงจรไปที่โครงเครื่องใช้ไฟฟ้าหรือพื้นเปียก กระแสน้อยกว่าแต่ทำให้ไฟดูดได้ เบรกเกอร์ MCB ป้องกันไฟฟ้าลัดวงจร ส่วนไฟรั่วต้องใช้ RCBO หรือ RCD',
            ],
            [
                'q' => 'น้ำท่วมหรือฝนสาดเข้าบ้าน ต้องทำอย่างไรกับระบบไฟฟ้า?',
                'a' => 'ให้สับเบรกเกอร์ของวงจรชั้นล่างหรือเมนเบรกเกอร์ลงก่อนน้ำถึงเต้ารับ โดยตัวต้องแห้งและไม่ยืนอยู่ในน้ำ หลังน้ำลดห้ามเปิดไฟใช้ทันที เต้ารับ สายไฟ และเครื่องใช้ไฟฟ้าที่เปียกหรือจมน้ำต้องให้ช่างตรวจก่อน เพราะความชื้นที่ค้างอยู่ทำให้ไฟฟ้าลัดวงจรภายหลังได้',
            ],
            [
                'q' => 'ควรตรวจระบบไฟฟ้าในบ้านบ่อยแค่ไหน?',
                'a' => 'ควรตรวจระบบไฟฟ้าในบ้านอย่างน้อยปีละ 1 ครั้ง และตรวจทันทีเมื่อมีกลิ่นไหม้ เต้ารับมีรอยคล้ำ ไฟกะพริบ หรือเบรกเกอร์ตัดบ่อย บ้านอายุเกิน 15 ปี บ้านที่เพิ่งผ่านน้ำท่วม และบ้านที่ติดแอร์หรือเครื่องทำน้ำอุ่นเพิ่ม ควรให้ช่างไฟฟ้าตรวจสายไฟ จุดต่อ และตู้ไฟก่อนใช้งานตามปกติ',
            ],
        ];

        return [
            '@type' => 'FAQPage',
            'mainEntity' => array_map(static fn (array $item): array => [
                '@type' => 'Question',
                'name' => $item['q'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $item['a'],
                ],
            ], $faqs),
        ];
    }

    /**
     * FAQ answers must match on-page FAQ text exactly (SEO package).
     *
     * @return array<string, mixed>
     */
    private static function groundRodInstallationHomeFaqPage(): array
    {
        $faqs = [
            [
                'q' => 'ตอกแท่งกราวด์ในบ้านต้องใช้แท่งยาวเท่าไหร่?',
                'a' => 'มาตรฐาน วสท. 2564 กำหนดให้หลักดินหุ้มหรือชุบทองแดงเป็นไปตาม มอก. 3024-2563 เล่ม 2 หรือตามมาตรฐานของการไฟฟ้า จึงควรเลือกแท่งที่ระบุมาตรฐานนี้ สเปกที่ช่างนิยมใช้กับบ้านคือ 5/8 นิ้ว ยาว 2.4 เมตร ตอกลงดินให้มิด แล้ววัดค่าความต้านทานให้ไม่เกิน 5 โอห์ม ค่าโอห์มที่ผ่านไม่ได้แปลว่าตัวแท่งผ่านมาตรฐาน',
            ],
            [
                'q' => 'บ้านมีกันดูดแล้ว ยังต้องตอกแท่งกราวด์อีกไหม?',
                'a' => 'ต้องตอก มาตรฐาน วสท. 2564 กำหนดว่าวงจรที่ต้องมีกันดูด ต้องมีสายดินของบริภัณฑ์ไฟฟ้าด้วย กันดูดวัดกระแสที่ไหลไปและกลับของวงจร ถ้าไม่เท่ากันก็ตัดไฟ ส่วนสายดินพาไฟรั่วกลับทางที่มีความต้านทานต่ำ ทำให้ตัดไฟได้ทันทีก่อนคนไปสัมผัส สองอย่างจึงต้องใช้คู่กัน',
            ],
            [
                'q' => 'ติดตั้งสายดินราคาเท่าไหร่?',
                'a' => 'ติดตั้งสายดิน 1 จุด ราคาเริ่มประมาณ 2,600 บาท (ไม่รวม VAT) ประกอบด้วยค่าแรง 1,500 บาท แท่งกราวด์ 500 บาท และสายดิน 5 เมตร เมตรละ 120 บาท ถ้าติดกันดูด Schneider 50A เพิ่มประมาณ 4,800 บาท ส่วนการตอกแบบเดลต้า 3 แท่ง ประมาณ 6,500–9,500 บาท ขึ้นกับหน้างาน',
            ],
            [
                'q' => 'ตอกกราวด์ 1 จุดใช้เวลานานไหม ต้องดับไฟทั้งบ้านหรือเปล่า?',
                'a' => 'งานตอกแท่งกราวด์และเดินสายเข้าตู้ 1 จุดใช้เวลาประมาณ 2–4 ชั่วโมง ไม่ต้องดับไฟทั้งวัน ช่างจะตัดไฟเฉพาะช่วงที่ต่อสายในตู้คอนซูมเมอร์ ซึ่งมักใช้เวลาไม่เกิน 1 ชั่วโมง',
            ],
            [
                'q' => 'ต่อสายดินกับท่อประปาแทนการตอกแท่งกราวด์ได้ไหม?',
                'a' => 'ไม่ควรทำ ท่อประปาสมัยใหม่เป็นท่อ PVC ซึ่งไม่นำไฟฟ้า ส่วนท่อเหล็กเก่าอาจมีข้อต่อพลาสติกคั่นและผุกร่อน ทำให้ไฟรั่วไม่ลงดินและอาจทำให้ท่อน้ำมีไฟ ควรตอกแท่งกราวด์แยกและต่อเข้าบาร์กราวด์ในตู้เท่านั้น',
            ],
            [
                'q' => 'เมื่อไหร่ต้องตอกกราวด์แบบเดลต้า?',
                'a' => 'เมื่อแท่งเดี่ยววัดค่าได้เกิน 5 โอห์ม มาตรฐานให้ปักหลักดินเพิ่มและต่อหลักดินทั้งหมดเข้าด้วยกัน การวาง 3 แท่งเป็นสามเหลี่ยม (เดลต้า) เป็นวิธีหนึ่งเมื่อพื้นที่พอ มักเจอในบ้านบนดินถมใหม่ ดินทราย หรือดินแห้ง ที่ระยะห่าง 2.4 เมตร ค่าลดเหลือประมาณ 42% ของแท่งเดี่ยว แต่ต้องวัดซ้ำทุกครั้ง',
            ],
        ];

        return [
            '@type' => 'FAQPage',
            '@id' => route('blog.show', 'ground-rod-installation-home').'#faq',
            'mainEntity' => array_map(static fn (array $item): array => [
                '@type' => 'Question',
                'name' => $item['q'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $item['a'],
                ],
            ], $faqs),
        ];
    }

    /**
     * HowTo steps must match on-page process list exactly (SEO package).
     *
     * @return array<string, mixed>
     */
    private static function groundRodInstallationHomeHowTo(): array
    {
        $steps = [
            [
                'name' => 'สำรวจตู้และจุดตอก',
                'text' => 'เปิดตู้คอนซูมเมอร์ดูว่ามีบาร์กราวด์หรือไม่ และเลือกจุดตอกในดินเดิมที่ใกล้ตู้ที่สุด',
            ],
            [
                'name' => 'ขุดหลุมนำ',
                'text' => 'ขุดลึกประมาณ 30 ซม. และราดน้ำให้ดินนิ่ม',
            ],
            [
                'name' => 'ตอกแท่งให้ตั้งฉาก',
                'text' => 'ตอกแท่งที่ผ่าน มอก. 3024-2563 เล่ม 2 ให้ตั้งฉาก จนหัวแท่งต่ำกว่าผิวดินประมาณ 15–30 ซม.',
            ],
            [
                'name' => 'ต่อสายดินกับหัวแท่ง',
                'text' => 'ยึดด้วยแคลมป์ 1 ตัวต่อ 1 สาย หรือเชื่อมด้วยความร้อน สายต่อหลักดินต้องเป็นเส้นเดียวยาวตลอด',
            ],
            [
                'name' => 'เดินสายดินเข้าตู้',
                'text' => 'ร้อยท่อ PVC หรือท่อเหล็กช่วงที่โผล่พ้นดิน',
            ],
            [
                'name' => 'ต่อเข้าบาร์กราวด์',
                'text' => 'ตัดแหล่งจ่ายและวัดยืนยันว่าไม่มีแรงดัน แล้วต่อสายดินเข้าบาร์กราวด์ (G) ที่บริภัณฑ์ประธาน',
            ],
            [
                'name' => 'ทำบ่อพักหรือฝาตรวจ',
                'text' => 'ไม่เทปูนปิดหัวแท่ง เพื่อตรวจแคลมป์และวัดค่าภายหลังได้',
            ],
            [
                'name' => 'วัดค่าและทดสอบ',
                'text' => 'วัดค่าความต้านทานด้วย Earth Tester ให้ไม่เกิน 5 โอห์ม และกดปุ่ม Test ที่กันดูด',
            ],
        ];

        return [
            '@type' => 'HowTo',
            'name' => 'ขั้นตอนตอกแท่งกราวด์ในบ้าน',
            'description' => 'ตอกแท่งกราวด์และต่อสายต่อหลักดินเข้าบาร์กราวด์ที่บริภัณฑ์ประธาน (ตู้เมน)',
            'totalTime' => 'PT4H',
            'estimatedCost' => [
                '@type' => 'MonetaryAmount',
                'currency' => 'THB',
                'value' => '2600',
            ],
            'supply' => [
                ['@type' => 'HowToSupply', 'name' => 'แท่งกราวด์ตาม มอก. 3024-2563 เล่ม 2 (นิยม 5/8 นิ้ว ยาว 2.4 เมตร)'],
                ['@type' => 'HowToSupply', 'name' => 'สายดินสีเขียวคาดเหลือง'],
                ['@type' => 'HowToSupply', 'name' => 'แคลมป์ทองเหลืองสำหรับกราวด์ร็อด'],
            ],
            'tool' => [
                ['@type' => 'HowToTool', 'name' => 'ค้อนปอนด์หรือสว่านโรตารี่หัวตอก'],
                ['@type' => 'HowToTool', 'name' => 'เครื่องวัด Earth Ground Tester'],
            ],
            'step' => array_map(static fn (array $item, int $index): array => [
                '@type' => 'HowToStep',
                'position' => $index + 1,
                'name' => $item['name'],
                'text' => $item['text'],
            ], $steps, array_keys($steps)),
        ];
    }

    /**
     * FAQ answers must match on-page FAQ text exactly (SEO package).
     *
     * @return array<string, mixed>
     */
    private static function bigTreeCuttingPriceFaqPage(): array
    {
        $faqs = [
            [
                'q' => 'ตัดต้นไม้ใหญ่ ราคาเท่าไหร่ต่อต้น?',
                'a' => 'งานตัดกิ่งใหญ่หรือต้นสูงใกล้บ้านและสายไฟเริ่มประมาณ 3,500 บาทต่อต้น งานตัดแต่งต้นขนาดกลางเริ่ม 1,500 บาทต่อต้น ส่วนงานโค่นทั้งต้นเริ่มประมาณ 5,000 บาทขึ้นไป และงานโค่นแบบทยอยตัดลงทีละท่อนมักอยู่ที่ 10,000–25,000 บาท ราคาจริงขึ้นกับความสูง ตำแหน่ง และปริมาณกิ่งที่ต้องขนออก',
            ],
            [
                'q' => 'ราคาค่าตัดต้นไม้ใหญ่ขึ้นอยู่กับอะไรบ้าง?',
                'a' => 'ขึ้นกับ 6 ปัจจัยหลัก คือ ความสูงและทรงพุ่ม ขนาดลำต้น ตำแหน่งของต้นไม้ สายไฟและสิ่งกีดขวาง ปริมาณเศษไม้ที่ต้องขนทิ้ง และอุปกรณ์พิเศษ เช่น นั่งร้าน รถกระเช้า หรือเครน ต้นไม้ขนาดเท่ากันอาจต่างราคากันได้หลายเท่าถ้าตำแหน่งหน้างานยากกว่า',
            ],
            [
                'q' => 'ตัดแต่งกิ่ง โค่นทั้งต้น หรือขุดตอ ต่างกันอย่างไร?',
                'a' => 'ตัดแต่งกิ่งคือเก็บต้นไว้แต่ลดทรงพุ่มและตัดกิ่งเสี่ยง โค่นทั้งต้นคือตัดลำต้นออกเหลือตอสูงประมาณ 30–50 ซม. ส่วนขุดตอคือถอนรากออกเพื่อใช้พื้นที่ต่อ หากรากเริ่มดันพื้นในตัวบ้าน ควรตัดพร้อมขุดรากในครั้งเดียว',
            ],
            [
                'q' => 'ต้นไม้ใหญ่พาดสายไฟ ตัดเองได้ไหม?',
                'a' => 'ไม่ควรตัดเอง หากกิ่งแตะหรืออยู่ใกล้สายไฟแรงสูง ให้แจ้งการไฟฟ้านครหลวงที่ 1130 หรือการไฟฟ้าส่วนภูมิภาคที่ 1129 ก่อนเริ่มงาน กิ่งไม้สดนำไฟฟ้าได้ และเลื่อยหรือบันไดที่แตะสายไฟเสี่ยงไฟดูดถึงชีวิต',
            ],
            [
                'q' => 'ต้องขออนุญาตก่อนตัดต้นไม้ใหญ่ในบ้านตัวเองไหม?',
                'a' => 'ต้นไม้ในที่ดินที่มีโฉนดหรือสิทธิครอบครองของเจ้าของเอง โดยทั่วไปตัดได้โดยไม่ต้องขออนุญาตกรมป่าไม้ แต่ถ้าอยู่บนทางเท้าหรือที่สาธารณะต้องติดต่อสำนักงานเขตหรือเทศบาลก่อน และถ้าอยู่ในหมู่บ้านจัดสรรหรือคอนโดควรแจ้งนิติบุคคลล่วงหน้า',
            ],
            [
                'q' => 'ค่าตัดต้นไม้ใหญ่รวมค่าขนเศษไหม?',
                'a' => 'ใบเสนอราคาของธีรพงษ์เซอร์วิสรวมค่าขนเศษกิ่งและท่อนไม้ตามที่ระบุในขอบเขตงาน ไม่ทิ้งกองกิ่งไว้หน้าบ้านหลังงานเสร็จ หากปริมาณเศษมากอาจคิดตามจำนวนเที่ยวรถและแจ้งไว้ก่อนเริ่มงาน',
            ],
            [
                'q' => 'ตัดต้นไม้ใหญ่ใช้เวลากี่วัน?',
                'a' => 'บ้านทั่วไปใช้เวลาตั้งแต่ติดต่อจนทำงานเสร็จประมาณ 1–3 วันทำงาน งานตัดแต่งกิ่งมักครึ่งวันถึง 1 วัน งานโค่น 1–2 วัน ส่วนงานตัดพร้อมขุดรากเช่นเคสซอยนวมินทร์ 30 ใช้เวลา 2 วัน',
            ],
            [
                'q' => 'ส่งรูปประเมินราคาตัดต้นไม้ใหญ่ได้ไหม?',
                'a' => 'ได้ ส่งรูปต้นไม้ 2–3 มุม ความสูงโดยประมาณ และตำแหน่งที่ตั้งมาทาง LINE @theeraphong หรือโทร 061-563-9228 ทีมงานประเมินราคาเบื้องต้นให้ฟรี หากต้องลงสำรวจหน้างานจริงมีค่าใช้จ่ายเริ่มต้น 1,500 บาท และหักคืนเมื่อว่าจ้าง',
            ],
        ];

        return [
            '@type' => 'FAQPage',
            'mainEntity' => array_map(static fn (array $item): array => [
                '@type' => 'Question',
                'name' => $item['q'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $item['a'],
                ],
            ], $faqs),
        ];
    }

    /**
     * HowTo steps must match on-page process list exactly (SEO package).
     *
     * @return array<string, mixed>
     */
    private static function bigTreeCuttingPriceHowTo(): array
    {
        $steps = [
            [
                'name' => 'ส่งรูปและรายละเอียด',
                'text' => 'ส่งรูปต้นไม้ 2–3 มุม ความสูงโดยประมาณ และตำแหน่งใกล้บ้าน หลังคา หรือสายไฟ ทาง LINE @theeraphong หรือโทร 061-563-9228',
            ],
            [
                'name' => 'ประเมินราคา',
                'text' => 'ทีมงานประเมินเบื้องต้นจากรูปโดยไม่มีค่าใช้จ่าย หากต้องลงสำรวจหน้างานจริง ค่าใช้จ่ายเริ่มต้น 1,500 บาท และหักคืนเมื่อตกลงว่าจ้าง',
            ],
            [
                'name' => 'ยืนยันขอบเขตและวันทำงาน',
                'text' => 'ยืนยันจำนวนต้น วิธีตัด ความสูงตอที่เหลือ ค่าขนเศษ วันเวลาทำงาน และจุดจอดรถก่อนเริ่มงาน',
            ],
            [
                'name' => 'ตัดและเก็บงาน',
                'text' => 'ทีมงานตัดตามแผน เก็บกิ่งใบ ขนท่อนไม้ขึ้นรถ และทำความสะอาดพื้นที่ก่อนส่งมอบ',
            ],
        ];

        return [
            '@type' => 'HowTo',
            'name' => 'ขั้นตอนรับจ้างตัดต้นไม้ใหญ่ ตั้งแต่ส่งรูปจนเก็บงาน',
            'description' => 'การรับจ้างตัดต้นไม้ใหญ่ของธีรพงษ์เซอร์วิสมี 4 ขั้นตอน ใช้เวลาตั้งแต่ติดต่อจนทำงานเสร็จประมาณ 1–3 วันทำงานสำหรับบ้านทั่วไป',
            'totalTime' => 'P3D',
            'step' => array_map(static fn (array $item, int $index): array => [
                '@type' => 'HowToStep',
                'position' => $index + 1,
                'name' => $item['name'],
                'text' => $item['text'],
            ], $steps, array_keys($steps)),
        ];
    }

    /**
     * FAQ answers must match on-page FAQ text exactly (SEO package).
     *
     * @return array<string, mixed>
     */
    private static function treeCuttingServiceRootRemovalFaqPage(): array
    {
        $faqs = [
            [
                'q' => 'How much does a tree cutting service cost in Bangkok?',
                'a' => 'Tree trimming starts from 1,500 THB per tree. Tree felling starts from 5,000 THB for a 6–10 m tree in an open area, and from 10,000 THB for sectional felling of a 10–15 m tree next to a house. Stump and root removal starts from 2,500 THB per stump. The final price is confirmed after a site survey.',
            ],
            [
                'q' => 'What is the difference between tree trimming and tree felling?',
                'a' => 'Tree trimming removes branches to reduce the canopy and keeps the tree alive. Tree felling removes the whole tree down to a stump. Trimming is cheaper and suits healthy trees that are only too dense. Felling is the right choice when roots damage a structure or the tree has outgrown its space.',
            ],
            [
                'q' => 'Do I need to remove the roots after felling a tree?',
                'a' => 'Yes, if the roots are near a floor, paving, wall or brick border. Felling leaves a stump about 30–50 cm high, and the roots below can keep spreading or rot and leave voids. Root removal usually takes one extra day and starts from 2,500 THB per stump.',
            ],
            [
                'q' => 'How long does tree felling with root removal take?',
                'a' => 'A typical job with one or two large trees takes about 2 days: one day for cutting and one day for root removal and hauling. Our Soi Nawamin 30 job, with two 10–14 m trees next to a house, was finished in 2 days by a 6-person crew.',
            ],
            [
                'q' => 'Can you cut a tree that is touching power lines?',
                'a' => 'Yes. We plan the cut order, remove the branches touching or overhanging the wires first, and lower every piece by rope so nothing drops onto the line. For high-voltage lines, the work may need coordination with the electricity authority before cutting starts.',
            ],
            [
                'q' => 'Can I get a quote without a site visit?',
                'a' => 'Yes. Send 2–3 photos of the tree, its trunk and anything nearby, such as the house or wires, to LINE @theeraphong for a free preliminary price. A site survey costs 1,500 THB and is deducted from the job if you hire us.',
            ],
        ];

        return [
            '@type' => 'FAQPage',
            '@id' => route('blog.show', 'tree-cutting-service-root-removal').'#faq',
            'mainEntity' => array_map(static fn (array $item): array => [
                '@type' => 'Question',
                'name' => $item['q'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $item['a'],
                ],
            ], $faqs),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private static function treeCuttingServiceRootRemovalService(string $blogUrl): array
    {
        return [
            '@type' => 'Service',
            '@id' => "{$blogUrl}#service",
            'serviceType' => 'Tree cutting service',
            'name' => 'Tree cutting, tree trimming, tree felling and root removal',
            'provider' => OrganizationSchema::reference(),
            'areaServed' => [
                'Bangkok',
                'Nonthaburi',
                'Pathum Thani',
                'Samut Prakan',
                'Samut Sakhon',
                'Nakhon Pathom',
            ],
            'offers' => [
                '@type' => 'Offer',
                'priceCurrency' => 'THB',
                'priceSpecification' => [
                    '@type' => 'PriceSpecification',
                    'minPrice' => 1500,
                    'priceCurrency' => 'THB',
                ],
            ],
        ];
    }

    /**
     * FAQ answers must match on-page FAQ text exactly (SEO package).
     *
     * @return array<string, mixed>
     */
    private static function junkRemovalNonthaburiFaqPage(): array
    {
        $faqs = [
            [
                'q' => 'รับจ้างขนขยะไปทิ้งราคาเท่าไหร่?',
                'a' => 'ราคาคิดตามจำนวนเที่ยวรถเป็นหลัก แล้วปรับตามน้ำหนักของ ระยะเดินขนจากจุดกองถึงรถ และงานรื้อที่ต้องทำเพิ่ม งานของเก่าเก็บขนาดลานบ้านแบบงานนี้อยู่ที่ 1,500 บาท ส่งรูปกองของมาทาง LINE แล้วทีมงานแจ้งราคาเหมาก่อนเริ่มงาน ไม่มีค่าใช้จ่ายเพิ่มภายหลังถ้าปริมาณของไม่เปลี่ยน',
            ],
            [
                'q' => 'รับขนขยะชิ้นใหญ่ เช่น อ่างอาบน้ำ ตู้ โต๊ะเหล็ก ไหม?',
                'a' => 'รับครับ งานที่ถนนเลี่ยงเมืองนนทบุรีมีทั้งอ่างอาบน้ำ ตู้เหล็กเก่า โต๊ะและเก้าอี้เหล็ก ตอไม้ และบานประตูไม้ ทีมงานยกและขนขึ้นรถเองทั้งหมด ของที่ใหญ่เกินช่องประตูจะรื้อหรือตัดแยกชิ้นที่หน้างานก่อนขน เจ้าของบ้านไม่ต้องช่วยยก',
            ],
            [
                'q' => 'ต้องคัดแยกขยะเองก่อนไหม?',
                'a' => 'ไม่ต้องครับ ทีมงานคัดแยกให้ที่หน้างาน โดยแยกเหล็ก ขวดแก้ว ยางรถ ไม้ และขยะทั่วไปออกจากกัน การคัดแยกช่วยให้จัดของขึ้นรถได้แน่นขึ้น ใช้เที่ยวรถน้อยลง และแยกของที่ส่งรีไซเคิลได้ออกจากของที่ต้องทิ้ง สิ่งที่เจ้าของบ้านควรทำคือแยกของที่ยังจะเก็บไว้ออกมาก่อนวันนัด',
            ],
            [
                'q' => 'ขยะที่ขนออกไปเอาไปทิ้งที่ไหน?',
                'a' => 'ขยะทั่วไปนำไปทิ้งที่บ่อขยะที่ได้รับอนุญาต ส่วนเหล็ก ขวดแก้ว และของที่รีไซเคิลได้ส่งร้านรับซื้อของเก่า เราไม่ทิ้งตามที่รกร้าง ริมถนน หรือริมคลอง เพราะเจ้าของบ้านอาจถูกตามตัวและมีความผิดตามกฎหมายรักษาความสะอาด ขอดูรูปจุดทิ้งได้ทุกงาน',
            ],
            [
                'q' => 'มีคนรับจ้างขนขยะไปทิ้งใกล้ฉันในนนทบุรีไหม?',
                'a' => 'มีครับ บริษัท ธีรพงษ์ เซอร์วิส จำกัด รับงานขนขยะและเคลียร์ของเก่าในจังหวัดนนทบุรี เช่น ถนนเลี่ยงเมืองนนทบุรี งามวงศ์วาน แคราย ติวานนท์ และรัตนาธิเบศร์ รวมถึง กรุงเทพฯ และปริมณฑล ส่งพิกัดหน้างานทาง LINE 0627188847 เพื่อเช็กวันว่างและประเมินราคา',
            ],
        ];

        return [
            '@type' => 'FAQPage',
            '@id' => route('blog.show', 'junk-removal-nonthaburi').'#faq',
            'mainEntity' => array_map(static fn (array $item): array => [
                '@type' => 'Question',
                'name' => $item['q'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $item['a'],
                ],
            ], $faqs),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private static function junkRemovalNonthaburiService(string $blogUrl): array
    {
        return [
            '@type' => 'Service',
            '@id' => "{$blogUrl}#service",
            'serviceType' => 'รับจ้างขนขยะไปทิ้ง',
            'name' => 'รับจ้างขนขยะและเคลียร์ของเก่าเก็บ นนทบุรี',
            'provider' => OrganizationSchema::reference(),
            'areaServed' => [
                ['@type' => 'AdministrativeArea', 'name' => 'นนทบุรี'],
                ['@type' => 'AdministrativeArea', 'name' => 'กรุงเทพมหานคร'],
            ],
            'image' => [
                'https://pub-68154224aa0d447b83de9bf218e76277.r2.dev/images/blogs/blogscontent/junk-removal-nonthaburi-2026-11-24/before-01.webp',
                'https://pub-68154224aa0d447b83de9bf218e76277.r2.dev/images/blogs/blogscontent/junk-removal-nonthaburi-2026-11-24/in-progress-01.webp',
                'https://pub-68154224aa0d447b83de9bf218e76277.r2.dev/images/blogs/blogscontent/junk-removal-nonthaburi-2026-11-24/After-01.webp',
            ],
        ];
    }

    private static function breadcrumbList(Blog $blog, string $blogUrl, string $base): array
    {
        $crumbName = match ($blog->slug) {
            'tree-cutting-service-root-removal' => 'Tree Cutting Service Case Study',
            'junk-removal-nonthaburi' => 'ขนขยะ ถ.เลี่ยงเมืองนนทบุรี',
            default => $blog->title,
        };

        $blogsCrumb = $blog->slug === 'tree-cutting-service-root-removal' ? 'Blog' : 'Blogs';
        $homeCrumb = $blog->slug === 'junk-removal-nonthaburi' ? 'หน้าแรก' : 'Home';
        if ($blog->slug === 'junk-removal-nonthaburi') {
            $blogsCrumb = 'บทความ';
        }

        return [
            '@type' => 'BreadcrumbList',
            '@id' => "{$blogUrl}#breadcrumb",
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => $homeCrumb,
                    'item' => $base,
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => $blogsCrumb,
                    'item' => route('blog.index'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => $crumbName,
                    'item' => $blogUrl,
                ],
            ],
        ];
    }

    private static function language(Blog $blog): string
    {
        return $blog->slug === 'tree-cutting-service-root-removal' ? 'en' : 'th';
    }

    /**
     * Thai has no reliable ASCII word boundaries; approximate word count as chars / 4.
     */
    private static function wordCount(Blog $blog): int
    {
        $text = trim(strip_tags((string) $blog->content));

        if ($text === '') {
            return 0;
        }

        return (int) max(1, ceil(mb_strlen($text) / 4));
    }

    private static function keywords(Blog $blog): string
    {
        $terms = [];

        if ($blog->relationLoaded('service') && $blog->service?->relationLoaded('category')) {
            $category = $blog->service->category?->name;
            if ($category) {
                $terms[] = $category;
            }
        }

        $terms = array_merge($terms, self::titleDerivedTerms($blog->title));

        return implode(', ', array_values(array_unique(array_filter($terms))));
    }

    /**
     * @return list<string>
     */
    private static function titleDerivedTerms(string $title): array
    {
        $normalized = preg_replace('/\s*\([^)]*\)\s*/u', ' ', $title) ?? $title;
        $normalized = preg_replace('/[&\/\\|,;:]+/u', ' ', $normalized) ?? $normalized;
        $parts = preg_split('/\s+/u', trim($normalized), -1, PREG_SPLIT_NO_EMPTY) ?: [];

        return array_values(array_filter(
            $parts,
            fn (string $part) => mb_strlen($part) >= 2,
        ));
    }
}
