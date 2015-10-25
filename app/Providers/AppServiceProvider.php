<?php

namespace App\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('linkToCustomer', function ($customer) {

            $array = explode(",", substr($customer, 1, -1));
            $output = '<?php echo " ';
            $output .= '<a href=\"' . url("customer/view?cus_id=" . $array[0]) . '\"><span class=\"customer_link\">' . $array[1] . '</span></a>';
            $output .= ' " ; ?>';

            //dd($array);
            return $output;

        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
