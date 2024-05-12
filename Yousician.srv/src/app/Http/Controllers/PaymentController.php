<?php

namespace App\Http\Controllers;

use Slim\Http\Response;
use Slim\Http\ServerRequest;

class PaymentController extends Controller
{
    public function profilePolicies(ServerRequest $request, Response $response)
    {
        $objectJson = [
            "licensed_content" => true,
            "can_subscribe" => true,
            "can_start_free_trial" => true,
            "localization_country" => "US",
            "sales_tax" => false,
        ];
        return $response->withJson($objectJson);
    }

    public function subscription(ServerRequest $request, Response $response)
    {
        $objectJson = [
            "adyen_details" => [
                "card_brand" => "visa",
                "card_expiration" => "2099-12-31T00:00:00Z",
                "card_number_last4" => "1234",
                "payment_method" => "debit",
                "payment_method_variant" => "visasuperpremiumdebit",
            ],
            "billing" => [
                "incident" => null,
                "next" => [
                    "date" => "2099-12-31T00:00:00.715000+00:00",
                    "discount" => null,
                    "full_plan_price" => ["amount" => 8299, "currency" => "EUR"],
                    "price" => ["amount" => 8299, "currency" => "EUR"],
                ],
                "previous" => null,
            ],
            "billing_incident" => null,
            "current_plan" => [
                "adyen" => [
                    "free_trial_available" => true,
                    "free_trial_duration" => ["number" => 0, "unit" => "day"],
                    "id" => "yearly_licensed_alt_a",
                    "introductory_offer" => null,
                    "price" => [
                        "amount" => 8299,
                        "currency" => "EUR",
                        "discount" => null,
                    ],
                    "purchase_trigger" => null,
                ],
                "core_plan_data" => [
                    "billing_period" => ["number" => 1, "unit" => "year"],
                    "features" => [
                        "all_instruments" => true,
                        "family" => false,
                        "instrument" => "all",
                        "licensed_content" => true,
                    ],
                    "is_upgradable" => true,
                    "price" => ["amount" => 8299, "currency" => "EUR"],
                    "renewable" => true,
                    "subscription_period" => ["number" => 1, "unit" => "year"],
                ],
                "core_plan_id" => "yearly_licensed_alt_a",
                "core_plan_name" => "Yearly Premium+ Subscription",
                "gateway" => "adyen",
                "googleplay" => null,
                "itunes" => null,
            ],
            "fixed" => null,
            "free_trial_info" => ["current_state" => "not_used"],
            "free_trial_state" => "not_used",
            "gateway" => "adyen",
            "given_by_admin" => false,
            "googleplay_details" => null,
            "itunes_details" => null,
            "policies" => [
                "can_resubscribe" => false,
                "can_switch_to_premium_plus" => false,
                "can_upgrade" => true,
            ],
            "renewable" => [
                "canceled" => false,
                "cancellation_date" => null,
                "period_end_date" => "2099-12-31T00:00:00.715000+00:00",
                "period_start_date" => "2000-01-01T00:00:00.715000+00:00",
            ],
            "subscribed_instrument" => "all",
        ];
        return $response->withJson($objectJson);
    }

    public function subscriptionV1(ServerRequest $request, Response $response)
    {
        $objectJson = [
            "payment_method" => "paypal",
        ];
        return $response->withJson($objectJson);
    }

    public function availablePlans(ServerRequest $request, Response $response)
    {
        $objectJson = [
            "plans" => [
                [
                    "itunes" => null,
                    "core_plan_name" => "Yearly Premium+ Subscription",
                    "googleplay" => null,
                    "adyen" => [
                        "id" => "yearly_licensed_alt_a",
                        "free_trial_duration" => ["number" => 7, "unit" => "day"],
                        "purchase_trigger" => null,
                        "introductory_offer" => null,
                        "free_trial_available" => true,
                        "price" => [
                            "discount" => null,
                            "currency" => "EUR",
                            "amount" => 8299,
                        ],
                    ],
                    "core_plan_data" => [
                        "features" => [
                            "family" => false,
                            "licensed_content" => true,
                            "instrument" => "all",
                            "all_instruments" => true,
                        ],
                        "family_linked_core_plan_id" => null,
                        "is_upgradable" => true,
                        "renewable" => true,
                        "is_family_plan" => false,
                        "billing_period" => ["number" => 1, "unit" => "year"],
                        "price" => ["currency" => "EUR", "amount" => 8299],
                        "subscription_period" => ["number" => 1, "unit" => "year"],
                    ],
                    "gateway" => "adyen",
                    "core_plan_id" => "yearly_licensed_alt_a",
                ],
                [
                    "itunes" => null,
                    "core_plan_name" => "Yearly Subscription",
                    "googleplay" => null,
                    "adyen" => [
                        "id" => "yearly_alt_a",
                        "free_trial_duration" => ["number" => 7, "unit" => "day"],
                        "purchase_trigger" => null,
                        "introductory_offer" => null,
                        "free_trial_available" => true,
                        "price" => [
                            "discount" => null,
                            "currency" => "EUR",
                            "amount" => 5999,
                        ],
                    ],
                    "core_plan_data" => [
                        "features" => [
                            "family" => false,
                            "licensed_content" => false,
                            "instrument" => null,
                            "all_instruments" => false,
                        ],
                        "family_linked_core_plan_id" => null,
                        "is_upgradable" => true,
                        "renewable" => true,
                        "is_family_plan" => false,
                        "billing_period" => ["number" => 1, "unit" => "year"],
                        "price" => ["currency" => "EUR", "amount" => 5999],
                        "subscription_period" => ["number" => 1, "unit" => "year"],
                    ],
                    "gateway" => "adyen",
                    "core_plan_id" => "yearly_alt_a",
                ],
            ],
            "introductory_price_ad_details" => null,
        ];
        return $response->withJson($objectJson);
    }
}