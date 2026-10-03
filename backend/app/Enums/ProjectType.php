<?php

namespace App\Enums;

enum ProjectType: string
{
    case Web = 'web';
    case Mobile = 'mobile';
    case BusinessSystems = 'business_systems';
    case Ecommerce = 'ecommerce';
    case Saas = 'saas';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Web => __('enums.project_type.web'),
            self::Mobile => __('enums.project_type.mobile'),
            self::BusinessSystems => __('enums.project_type.business_systems'),
            self::Ecommerce => __('enums.project_type.ecommerce'),
            self::Saas => __('enums.project_type.saas'),
            self::Other => __('enums.project_type.other'),
        };
    }
}
