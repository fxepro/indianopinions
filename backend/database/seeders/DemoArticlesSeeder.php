<?php

namespace Database\Seeders;

use App\Enums\PostStatus;
use App\Enums\UserRole;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoArticlesSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@indianopinions.com'],
            ['name' => 'Site Admin', 'password' => Hash::make('password'), 'role' => UserRole::Editor->value, 'is_active' => true]
        );

        $writer = User::firstWhere('email', 'writer@indianopinions.com')
            ?? User::updateOrCreate(
                ['email' => 'writer@indianopinions.com'],
                ['name' => 'Staff Writer', 'password' => Hash::make('password'), 'role' => UserRole::Writer->value, 'is_active' => true]
            );

        $articles = [
            // Politics
            [
                'category' => 'politics',
                'slug' => 'coalition-calculus-monsoon-session',
                'title' => 'The Coalition Calculus After the Monsoon Session',
                'author' => 'Ananya Deshpande',
                'excerpt' => 'With regional parties holding the balance of power, the government’s legislative agenda now depends as much on state-level arithmetic as on parliamentary headcount.',
                'featured' => true,
                'reading_time' => 8,
                'image' => 'https://images.unsplash.com/photo-1529107386315-e1a2ed48a620?w=1200&h=675&fit=crop',
                'tags' => ['india', 'policy'],
                'days_ago' => 1,
                'content' => <<<'HTML'
<p>The monsoon session ended without the dramatic walkouts that dominated last winter, but the quiet negotiations in committee rooms may matter more. Three regional allies now condition their support on district-level fund releases, not national talking points.</p>
<p>For the treasury benches, that means every major bill arrives pre-negotiated with state capitals. Opposition parties, meanwhile, have learned to weaponize federal friction — forcing votes that expose fissures within the ruling bloc without offering an alternative majority.</p>
<p>The result is a legislature that looks stable on paper and fragile in practice. Watch the winter session: if coalition partners begin linking support to cabinet reshuffles, Delhi’s policy calendar could slip by a full quarter.</p>
HTML,
            ],
            [
                'category' => 'politics',
                'slug' => 'state-welfare-politics-reshaping-delhi',
                'title' => 'Why State-Level Welfare Politics Is Reshaping Delhi',
                'author' => 'Rahul Menon',
                'excerpt' => 'Cash transfers pioneered in the states are becoming the template for national welfare debates — and rewriting the centre–state compact.',
                'featured' => false,
                'reading_time' => 6,
                'image' => 'https://images.unsplash.com/photo-1577896847721-8499e3973b54?w=1200&h=675&fit=crop',
                'tags' => ['india', 'policy', 'society'],
                'days_ago' => 4,
                'content' => <<<'HTML'
<p>When a southern state rolled out a guaranteed income pilot last year, critics dismissed it as election-season theatre. Twelve months later, two northern states have copied the design with minor tweaks — and the finance ministry is studying portability across Aadhaar rails.</p>
<p>This is not merely policy diffusion. It signals a shift in where Indian voters look for material improvement: increasingly to chief ministers who can deliver benefits within a single term, not to abstract national narratives.</p>
HTML,
            ],
            // Economy
            [
                'category' => 'economy',
                'slug' => 'manufacturing-second-act-pli-schemes',
                'title' => "Manufacturing's Second Act: PLI Schemes at the Five-Year Mark",
                'author' => 'Priya Krishnamurthy',
                'excerpt' => 'Production-linked incentives were meant to jump-start factories. Half a decade in, the question is whether they build lasting competitiveness or dependency on subsidies.',
                'featured' => false,
                'reading_time' => 7,
                'image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=1200&h=675&fit=crop',
                'tags' => ['economy', 'technology'],
                'days_ago' => 2,
                'content' => <<<'HTML'
<p>Electronics assembly lines in western India now run three shifts where warehouses stood a decade ago. PLI disbursements explain part of that transformation — but so do logistics upgrades and a tighter focus on component localization.</p>
<p>The harder test arrives when incentives taper. Firms that treated PLI as margin padding will exit; those that reinvested in supplier development may survive the cliff. Policy makers should measure success by export quality, not headline investment pledges.</p>
HTML,
            ],
            [
                'category' => 'economy',
                'slug' => 'rupee-fed-india-external-balancing',
                'title' => "The Rupee, the Fed, and India's External Balancing Act",
                'author' => 'Vikram Joshi',
                'excerpt' => 'Dollar strength and volatile capital flows are forcing RBI to choose between growth support and currency stability — with no painless option.',
                'featured' => false,
                'reading_time' => 5,
                'image' => 'https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?w=1200&h=675&fit=crop',
                'tags' => ['economy', 'analysis'],
                'days_ago' => 6,
                'content' => <<<'HTML'
<p>Portfolio investors returned to Indian equities in the second quarter, but FDI in manufacturing remained patchy. That asymmetry keeps the rupee sensitive to every Fed statement and every oil-price spike.</p>
<p>RBI’s intervention has been surgical rather than dramatic — selling dollars into strength, rebuilding reserves quietly. The risk is that growth-sensitive sectors, especially MSME exporters, absorb the adjustment through tighter credit long before consumers notice.</p>
HTML,
            ],
            // Foreign Affairs
            [
                'category' => 'foreign-affairs',
                'slug' => 'india-quad-commitments-strategic-autonomy',
                'title' => "India's Quad Commitments in an Era of Strategic Autonomy",
                'author' => 'Meera Kapoor',
                'excerpt' => 'Delhi wants deeper Indo-Pacific partnerships without being drawn into bloc politics. Washington, Tokyo, and Canberra each read that balance differently.',
                'featured' => false,
                'reading_time' => 9,
                'image' => 'https://images.unsplash.com/photo-1523961131990-5ea7c61b2107?w=1200&h=675&fit=crop',
                'tags' => ['analysis', 'policy'],
                'days_ago' => 3,
                'content' => <<<'HTML'
<p>Joint naval exercises have become routine, but India continues to resist language that frames the Quad as an Asian NATO. That restraint buys diplomatic space with Moscow and Beijing — and frustrates partners seeking sharper deterrence messaging.</p>
<p>The compromise so far: cooperate on maritime domain awareness and humanitarian assistance while keeping hard security guarantees bilateral. Whether that holds through the next Taiwan Strait crisis is the question every embassy in Delhi is quietly gaming out.</p>
HTML,
            ],
            [
                'category' => 'foreign-affairs',
                'slug' => 'middle-corridor-india-eurasian-gambit',
                'title' => "The Middle Corridor and India's Eurasian Gambit",
                'author' => 'Arjun Nair',
                'excerpt' => 'New trade routes through Central Asia could reduce chokepoint risk — if infrastructure, sanctions, and geopolitics align.',
                'featured' => false,
                'reading_time' => 7,
                'image' => 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=1200&h=675&fit=crop',
                'tags' => ['economy', 'analysis'],
                'days_ago' => 8,
                'content' => <<<'HTML'
<p>Indian exporters have long complained about Suez delays and Red Sea insecurity. The Middle Corridor offers an alternative on paper: rail links from Gujarat ports through Iran and the Caspian into Europe.</p>
<p>Paper routes, however, need terminals, insurance, and banking channels that sanctions regimes complicate. Delhi’s bet is incremental — pilot shipments, diplomatic shuttles, and patience — rather than a splashy announcement that overpromises transit times.</p>
HTML,
            ],
            // Society
            [
                'category' => 'society',
                'slug' => 'urban-migration-tier-two-cities',
                'title' => 'Urban Migration and the Reinvention of Tier-Two Cities',
                'author' => 'Kavita Iyer',
                'excerpt' => 'Remote work and rising metro rents are pushing young professionals toward Indore, Coimbatore, and Jaipur — with uneven consequences for public services.',
                'featured' => false,
                'reading_time' => 6,
                'image' => 'https://images.unsplash.com/photo-1449824913935-59a10b8d2000?w=1200&h=675&fit=crop',
                'tags' => ['society', 'india'],
                'days_ago' => 5,
                'content' => <<<'HTML'
<p>Cafés and co-working spaces multiply in city centres that once emptied after office hours. Municipal corporations, built for slower growth, struggle with waste management and bus frequency even as property tax receipts rise.</p>
<p>The social story is less about escape from metros than about renegotiating ambition: careers that no longer require a Mumbai address, but still depend on Mumbai networks — at least until local ecosystems mature.</p>
HTML,
            ],
            [
                'category' => 'society',
                'slug' => 'language-identity-classroom-multilingual-india',
                'title' => 'Language, Identity, and the Classroom in Multilingual India',
                'author' => 'Deepa Raman',
                'excerpt' => 'National education policy promises mother-tongue instruction, but teacher training and exam systems still reward a narrow band of languages.',
                'featured' => false,
                'reading_time' => 8,
                'image' => 'https://images.unsplash.com/photo-1503676260728-1c00da280a0e?w=1200&h=675&fit=crop',
                'tags' => ['society', 'policy'],
                'days_ago' => 10,
                'content' => <<<'HTML'
<p>In border districts, students code-switch before they code. Policy documents celebrate that reality; textbooks often ignore it. The gap shows up in dropout rates where regional languages dominate home life but English dominates employment ads.</p>
<p>States experimenting with early-grade bilingual modules report better retention, yet face a shortage of instructors comfortable in both pedagogical grammar and local dialect. Fixing that pipeline matters more than another curriculum rewrite.</p>
HTML,
            ],
            // Technology
            [
                'category' => 'technology',
                'slug' => 'upi-global-digital-public-infrastructure',
                'title' => 'UPI Goes Global: Digital Public Infrastructure as Diplomacy',
                'author' => 'Sanjay Malhotra',
                'excerpt' => 'Payment rails are becoming foreign-policy tools as India exports stack standards to Southeast Asia, Africa, and the Gulf.',
                'featured' => true,
                'reading_time' => 7,
                'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=1200&h=675&fit=crop',
                'tags' => ['technology', 'policy'],
                'days_ago' => 2,
                'content' => <<<'HTML'
<p>What began as a domestic convenience — paying a street vendor from a phone — is now a negotiating chip in trade talks. Countries adopting UPI-compatible switches gain faster remittance corridors; India gains influence over interoperability rules.</p>
<p>The challenge is governance: who audits fraud across borders, who sets liability when switches fail, and how open-source commitments survive vendor lobbying. DPI diplomacy only works if trust in the rails outlasts any single election cycle.</p>
HTML,
            ],
            [
                'category' => 'technology',
                'slug' => 'semiconductor-fabs-indian-tech-power',
                'title' => 'Semiconductor Fabs and the Geography of Indian Tech Power',
                'author' => 'Neha Bhat',
                'excerpt' => 'Chip plants promised for Gujarat and Assam symbolize ambition, but talent pipelines and power grids will decide whether fabs stay on schedule.',
                'featured' => false,
                'reading_time' => 6,
                'image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=1200&h=675&fit=crop',
                'tags' => ['technology', 'economy'],
                'days_ago' => 7,
                'content' => <<<'HTML'
<p>Groundbreakings make good television; yield rates make good businesses. India’s first commercial fabs will import much of their process knowledge initially, training local engineers on the line rather than in universities alone.</p>
<p>States competing for projects are upgrading substations and water recycling at unusual speed. The long game is not just chips — it is a supplier ecosystem that keeps design houses, tool vendors, and packaging plants within a few hours’ drive.</p>
HTML,
            ],
            // Diaspora
            [
                'category' => 'diaspora',
                'slug' => 'silicon-valley-surat-reverse-migration',
                'title' => 'From Silicon Valley to Surat: Reverse Migration Trends',
                'author' => 'Rohan Mehta',
                'excerpt' => 'A slice of the Indian tech diaspora is moving back — not out of nostalgia, but because startup capital and quality of life equations have shifted.',
                'featured' => false,
                'reading_time' => 5,
                'image' => 'https://images.unsplash.com/photo-1521737711862-e3b97375f902?w=1200&h=675&fit=crop',
                'tags' => ['diaspora', 'technology'],
                'days_ago' => 4,
                'content' => <<<'HTML'
<p>Founders who spent a decade in Bay Area product roles now cite Bangalore or Ahmedabad incubators, cheaper childcare, and parents aging at home as push-pull factors. The trend is still small against total emigration, but visible in venture deal flow.</p>
<p>Reverse migrants bring process discipline and network capital; they also bring expectations about governance and infrastructure that local ecosystems must meet or lose them again within two funding cycles.</p>
HTML,
            ],
            [
                'category' => 'diaspora',
                'slug' => 'indian-diaspora-soft-power-britain-america',
                'title' => "The Indian Diaspora's Soft Power in British and American Politics",
                'author' => 'Leela Choudhury',
                'excerpt' => 'Community leaders increasingly translate demographic weight into policy access — on visas, trade, and campus speech debates.',
                'featured' => false,
                'reading_time' => 8,
                'image' => 'https://images.unsplash.com/photo-1529107386315-e1a2ed48a620?w=1200&h=675&fit=crop',
                'tags' => ['diaspora', 'opinion'],
                'days_ago' => 9,
                'content' => <<<'HTML'
<p>Diwali receptions at Whitehall and Capitol Hill are no longer ceremonial. They precede working groups on skilled migration, medical licensing reciprocity, and dual-degree partnerships — issues that matter to constituencies with high Indian-origin populations.</p>
<p>Soft power, though, is not monolithic. Generational splits over Kashmir, caste, and campus politics show up in the same donor lists that fund bipartisan friendship caucuses. Delhi reads these fractures carefully when scheduling diaspora outreach.</p>
HTML,
            ],
            // Opinion
            [
                'category' => 'opinion',
                'slug' => 'letter-next-generation-policy-debaters',
                'title' => 'A Letter to the Next Generation of Policy Debators',
                'author' => 'Editorial Board',
                'excerpt' => 'Rigour matters more than virality. A plea for slow thinking in an age of instant outrage.',
                'featured' => false,
                'reading_time' => 4,
                'image' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?w=1200&h=675&fit=crop',
                'tags' => ['opinion'],
                'days_ago' => 3,
                'content' => <<<'HTML'
<p>You will be tempted to win arguments in screenshots. Resist. The policies that shape electricity prices, river waters, and hospital budgets are written in footnotes, not threads.</p>
<p>Read primary sources. Interview people who disagree with you. Publish corrections without drama. That is how Indian Opinions earned trust — and how you will keep it.</p>
HTML,
            ],
            [
                'category' => 'opinion',
                'slug' => 'institutional-memory-india-underrated-asset',
                'title' => "Institutional Memory Is India's Underrated Asset",
                'author' => 'Ashok Varma',
                'excerpt' => 'Civil services, central banks, and election commissions outlast governments. We undervalue them at our peril.',
                'featured' => false,
                'reading_time' => 5,
                'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=1200&h=675&fit=crop',
                'tags' => ['opinion', 'policy'],
                'days_ago' => 11,
                'content' => <<<'HTML'
<p>Every incoming minister arrives with a slide deck and a mandate to disrupt. Most leave without reading the last minister’s cabinet note. Institutions absorb that churn so citizens do not — until they are politicized past the breaking point.</p>
<p>Defending institutional memory is not defending the status quo. It is insisting that reformers know what was tried, what failed, and why before they announce the next big bang.</p>
HTML,
            ],
            // Analysis
            [
                'category' => 'analysis',
                'slug' => 'mapping-india-electoral-geography',
                'title' => "Mapping India's Electoral Geography: Ten Patterns Worth Watching",
                'author' => 'Research Desk',
                'excerpt' => 'From coastal swing belts to interior strongholds, our data team highlights structural shifts that campaigns are still adjusting to.',
                'featured' => true,
                'reading_time' => 12,
                'image' => 'https://images.unsplash.com/photo-1524661135-423995f22d0b?w=1200&h=675&fit=crop',
                'tags' => ['analysis', 'india', 'policy'],
                'days_ago' => 1,
                'content' => <<<'HTML'
<p>We mapped turnout, margin, and party vote share across 543 constituencies for three consecutive cycles. Ten patterns survived every regression: urban fringe volatility, youth-heavy seats flipping faster, and a widening gap between state and national verdicts in the same year.</p>
<p>Parties that treat these as noise will misallocate resources. Parties that treat them as signal can win without sweeping national waves — the new default in Indian politics.</p>
<p>Interactive maps and constituency tables accompany this report for subscribers. Below we summarize the findings most likely to shape alliance math in the next eighteen months.</p>
HTML,
            ],
            [
                'category' => 'analysis',
                'slug' => 'water-agriculture-fiscal-crisis-gangetic-plain',
                'title' => 'Water, Agriculture, and the Hidden Fiscal Crisis in the Gangetic Plain',
                'author' => 'Research Desk',
                'excerpt' => 'Groundwater depletion and power subsidies interact in ways state budgets barely acknowledge — until bond markets do.',
                'featured' => false,
                'reading_time' => 10,
                'image' => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=1200&h=675&fit=crop',
                'tags' => ['analysis', 'economy', 'society'],
                'days_ago' => 6,
                'content' => <<<'HTML'
<p>Free or cheap electricity for pumps keeps farmers afloat and state discoms underwater. As aquifers fall, borewells deepen and pumps draw more power — a feedback loop that shows up neither in agriculture GDP nor in climate pledges, but in annual bailout requests.</p>
<p>Fixing this requires metering politics as much as hydrology. Our field reporting across four states suggests pilots succeed when farmers co-own tariff design, not when reform arrives as a midnight notification.</p>
HTML,
            ],
        ];

        foreach ($articles as $index => $data) {
            $category = Category::where('slug', $data['category'])->first();

            if (! $category) {
                $this->command?->warn("Category [{$data['category']}] not found — run DatabaseSeeder first.");

                continue;
            }

            $post = Post::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'user_id' => $writer->id,
                    'title' => $data['title'],
                    'excerpt' => $data['excerpt'],
                    'content' => $data['content'],
                    'featured_image' => $data['image'],
                    'status' => PostStatus::Published->value,
                    'author' => $data['author'],
                    'reading_time' => $data['reading_time'],
                    'featured' => $data['featured'],
                    'published_at' => now()->subDays($data['days_ago'])->subHours($index),
                    'published_by_id' => $admin->id,
                    'reviewed_by_id' => $admin->id,
                    'reviewed_at' => now()->subDays($data['days_ago'] + 1),
                ]
            );

            $post->categories()->sync([$category->id]);

            $tagIds = Tag::whereIn('name', $data['tags'])->pluck('id');
            $post->tags()->sync($tagIds);
        }

        $this->command?->info('Seeded '.count($articles).' demo articles across editorial categories.');
    }
}
