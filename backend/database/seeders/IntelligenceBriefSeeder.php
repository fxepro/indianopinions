<?php

namespace Database\Seeders;

use App\Models\IntelligenceBrief;
use App\Models\IntelligenceBriefItem;
use App\Models\Post;
use Illuminate\Database\Seeder;

class IntelligenceBriefSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedEdition('2026-06-26', [
            'leads' => [
                [
                    'headline' => "Manufacturing's Second Act: PLI Schemes at the Five-Year Mark",
                    'blurb' => 'Electronics assembly in western India now runs three shifts where warehouses stood a decade ago. Production-linked incentives explain part of that shift, but logistics upgrades and component localisation matter equally. The harder test arrives when subsidies taper: firms that treated PLI as margin padding will exit, while those that reinvested in supplier development may survive the cliff. Policy makers should measure success by export quality and durable employment, not headline investment pledges alone. States competing for fabs and phone plants have upgraded power and water infrastructure at unusual speed; the question is whether that capacity remains utilised once incentives fade. For readers tracking industrial policy, the five-year mark is less a celebration than an audit.',
                    'post_slug' => 'manufacturing-second-act-pli-schemes',
                ],
                [
                    'headline' => "Mapping India's Electoral Geography: Ten Patterns Worth Watching",
                    'blurb' => 'Turnout, margin, and party vote share across 543 constituencies reveal structural shifts that campaigns still treat as noise. Urban fringe seats remain volatile; youth-heavy constituencies flip faster than rural strongholds; and the gap between state and national verdicts in the same cycle continues to widen. Parties that misallocate resources against these patterns lose winnable seats without sweeping national waves — increasingly the default in Indian politics. Coastal swing belts and interior bastions are diverging in ways alliance math cannot ignore over the next eighteen months. Our data team highlights ten patterns that survived three consecutive regression passes. None guarantees a winner, but together they explain why ground games matter more than national slogans in the current cycle.',
                    'post_slug' => 'mapping-india-electoral-geography',
                ],
            ],
            'hubs' => [
                'politics' => 'Cabinet reshuffles ahead of monsoon session suggest a pivot toward welfare delivery messaging in heartland states. Opposition alliances remain fragile on seat-sharing in Bihar and Maharashtra, while regional parties extract concessions on language and fiscal devolution. Institutional friction between governors and elected governments in southern states continues to surface in court dockets, not press releases — a pattern worth monitoring for federal balance.',
                'economy' => 'RBI intervention has been surgical rather than dramatic: selling dollars into strength while rebuilding reserves quietly. MSME exporters are absorbing rupee adjustment through tighter credit long before consumers notice. Portfolio flows returned to equities in the second quarter, but FDI in manufacturing remained patchy, keeping external balances sensitive to Fed signals and oil spikes. Growth-sensitive sectors face a prolonged adjustment window.',
                'foreign-affairs' => 'India resists Quad language that frames the grouping as an Asian NATO, buying diplomatic space with Moscow and Beijing while frustrating partners seeking sharper deterrence messaging. Joint naval exercises are routine; hard security guarantees stay bilateral. Delhi\'s bet on the Middle Corridor remains incremental — pilot shipments and diplomatic shuttles rather than splashy transit promises that overstate readiness across sanctions-sensitive banking channels.',
                'society' => 'Remote work and rising metro rents push young professionals toward Indore, Coimbatore, and Jaipur, with uneven consequences for municipal services. Cafés and co-working spaces multiply in centres that once emptied after office hours; waste management and bus frequency lag property-tax receipts. The story is less escape from metros than renegotiating ambition — careers that no longer require a Mumbai address but still depend on Mumbai networks.',
                'technology' => 'UPI-compatible payment switches are becoming trade-negotiation tools as India exports digital public infrastructure to Southeast Asia, Africa, and the Gulf. Fraud liability across borders and open-source commitments under vendor lobbying remain unresolved. Semiconductor fabs promised for Gujarat and Assam symbolise ambition, but talent pipelines and grid reliability will decide whether yield rates — not groundbreakings — define success.',
                'diaspora' => 'Community leaders translate demographic weight into policy access on visas, trade, and campus speech in Britain and America. Diwali receptions at Whitehall and Capitol Hill now precede working groups on skilled migration and dual-degree partnerships. Generational splits over Kashmir, caste, and campus politics appear in the same donor lists that fund bipartisan friendship caucuses — complicating embassy outreach in Delhi.',
                'opinion' => 'Editorial board note: rigour matters more than virality in policy debate. Primary sources, interviews with dissenting voices, and published corrections without drama are how trust compounds. The policies shaping electricity prices, river waters, and hospital budgets are written in footnotes, not threads — a standard the next generation of debaters should adopt before amplifying conclusions they have not verified.',
                'analysis' => 'Groundwater depletion and power subsidies interact in Gangetic Plain state budgets in ways bond markets are beginning to price. Free or cheap pump electricity keeps farmers afloat and discoms underwater; as aquifers fall, borewells deepen and draw more power — a feedback loop absent from agriculture GDP headlines. Field reporting across four states suggests tariff reform succeeds when farmers co-own design, not when it arrives as a midnight notification.',
            ],
        ]);

        $this->seedEdition('2026-06-25', [
            'leads' => [
                [
                    'headline' => 'UPI Goes Global: Digital Public Infrastructure as Diplomacy',
                    'blurb' => 'Payment rails are becoming foreign-policy tools as India exports stack standards to Southeast Asia, Africa, and the Gulf. What began as a domestic convenience is now a negotiating chip in trade talks: countries adopting UPI-compatible switches gain faster remittance corridors; India gains influence over interoperability rules. The challenge is governance — who audits fraud across borders, who sets liability when switches fail, and how open-source commitments survive vendor lobbying. DPI diplomacy only works if trust in the rails outlasts any single election cycle. For diplomats and fintech operators alike, the question is no longer whether UPI travels, but under whose rules it settles abroad.',
                    'post_slug' => 'upi-global-digital-public-infrastructure',
                ],
                [
                    'headline' => "India's Quad Commitments in an Era of Strategic Autonomy",
                    'blurb' => 'Delhi wants deeper Indo-Pacific partnerships without being drawn into bloc politics. Washington, Tokyo, and Canberra each read that balance differently. Joint naval exercises have become routine, but India continues to resist language that frames the Quad as an Asian NATO — buying space with Moscow and Beijing while frustrating partners seeking sharper deterrence messaging. The compromise so far: cooperate on maritime domain awareness and humanitarian assistance while keeping hard security guarantees bilateral. Whether that holds through the next Taiwan Strait crisis is the question every embassy in Delhi is quietly gaming out.',
                    'post_slug' => 'india-quad-commitments-strategic-autonomy',
                ],
            ],
            'hubs' => [
                'politics' => 'State assembly sessions in the northeast focus on inner-line permit reforms and employment quotas for indigenous communities. Centre-state negotiations over disaster relief funds for cyclone-hit coastlines remain unresolved, with opposition parties framing delays as electoral calculus ahead of winter polls.',
                'economy' => 'The rupee traded in a narrow band as RBI absorbed portfolio inflows without signalling a shift in rate policy. MSME credit growth slowed in tier-two cities even as metro consumer lending held steady — a divergence that complicates the narrative of uniform recovery.',
                'foreign-affairs' => 'Middle Corridor pilot shipments through Iran and the Caspian remain small-volume tests rather than commercial lanes. Insurance and banking channels constrained by sanctions regimes continue to cap how quickly Delhi can sell the route to European buyers seeking Red Sea alternatives.',
                'society' => 'Language policy debates resurfaced in border districts where students code-switch before they code. Early-grade bilingual pilots report better retention, yet teacher training pipelines lag behind curriculum announcements in three states.',
                'technology' => 'Semiconductor yield rates at announced fabs depend on imported process knowledge and local grid stability. States upgrading substations report progress; talent poaching between design houses and packaging plants intensifies in Bangalore and Ahmedabad.',
                'diaspora' => 'Reverse migration from Silicon Valley to Surat and Bangalore incubators remains a niche trend but visible in venture deal flow. Founders cite childcare costs and aging parents as pull factors; local ecosystems must meet governance expectations or lose returnees within two funding cycles.',
                'opinion' => 'A reminder from the editorial desk: slow thinking beats instant outrage in policy debate. Read primary sources, publish corrections without drama, and treat virality as a distraction from the footnotes where budgets are actually written.',
                'analysis' => 'Institutional memory in civil services and regulators outlasts governments — until politicisation erodes it. Reformers who ignore what was tried, failed, and why before announcing the next big bang repeat expensive mistakes across electricity, water, and health financing.',
            ],
        ]);
    }

    /** @param  array{leads: list<array{headline: string, blurb: string, post_slug?: string}>, hubs: array<string, string>}  $content */
    private function seedEdition(string $date, array $content): void
    {
        $brief = IntelligenceBrief::updateOrCreate(
            ['edition_date' => $date],
            ['published_at' => "{$date} 06:00:00"]
        );

        $brief->items()->delete();

        foreach ($content['leads'] as $position => $lead) {
            IntelligenceBriefItem::create([
                'intelligence_brief_id' => $brief->id,
                'type' => 'lead',
                'position' => $position,
                'headline' => $lead['headline'],
                'blurb' => $lead['blurb'],
                'post_id' => isset($lead['post_slug'])
                    ? Post::where('slug', $lead['post_slug'])->value('id')
                    : null,
            ]);
        }

        foreach (config('intelligence_brief.hub_slugs', []) as $position => $hubSlug) {
            if (! isset($content['hubs'][$hubSlug])) {
                continue;
            }

            IntelligenceBriefItem::create([
                'intelligence_brief_id' => $brief->id,
                'type' => 'hub',
                'hub_slug' => $hubSlug,
                'position' => $position,
                'blurb' => $content['hubs'][$hubSlug],
            ]);
        }
    }
}
