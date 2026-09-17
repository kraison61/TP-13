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
            'inLanguage' => 'th',
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
            'inLanguage' => 'th',
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

    private static function breadcrumbList(Blog $blog, string $blogUrl, string $base): array
    {
        return [
            '@type' => 'BreadcrumbList',
            '@id' => "{$blogUrl}#breadcrumb",
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Home',
                    'item' => $base,
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'Blogs',
                    'item' => route('blog.index'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => $blog->title,
                    'item' => $blogUrl,
                ],
            ],
        ];
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
