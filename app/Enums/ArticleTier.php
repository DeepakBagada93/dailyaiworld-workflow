<?php

namespace App\Enums;

enum ArticleTier: string
{
    case Breaking = 'Breaking';
    case DeepDive = 'Deep Dive';
    case FounderStory = 'Founder Story';
    case ResearchBreakdown = 'Research Breakdown';
    case Briefing = 'Briefing';
}
