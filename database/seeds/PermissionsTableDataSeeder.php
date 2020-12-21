<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Categorypermission;

class PermissionsTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $models = [
            "role", "user","category","subcategory","subsubcategory","blog","currency","product","aggregation","aucation","city","company","position","social"
        ];
        foreach($models as $model) {
            $category_permission            = new CategoryPermission;
            $category_permission->name      = $model;
            $category_permission->save();
            Permission::firstOrCreate(["name" => "create_$model", "display_name" => "Create $model", 'category_id' => $category_permission->id]);
            Permission::firstOrCreate(["name" => "edit_$model", "display_name" => "Edit $model", 'category_id' => $category_permission->id]);
            Permission::firstOrCreate(["name" => "delete_$model", "display_name" => "Delete $model", 'category_id' => $category_permission->id]);
            Permission::firstOrCreate(["name" => "index_$model", "display_name" => "Index $model", 'category_id' => $category_permission->id]);
            Permission::firstOrCreate(["name" => "view_$model", "display_name" => "View $model", 'category_id' => $category_permission->id]);
        }
        $categorypermission = new Categorypermission();
            $categorypermission->name="setting";
            $categorypermission->save();
            Permission::firstOrCreate(["name" => "dash_about", "display_name" => "about", 'category_id' => $categorypermission->id]);
            Permission::firstOrCreate(["name" => "dash_edit_general_setting", "display_name" => "edit general setting", 'category_id' => $categorypermission->id]);
            Permission::firstOrCreate(["name" => "home_section_1", "display_name" => "home section_1 ", 'category_id' => $categorypermission->id]);
            Permission::firstOrCreate(["name" => "edit_home_section_1", "display_name" => "edit home section_1", 'category_id' => $categorypermission->id]);
            Permission::firstOrCreate(["name" => "home_section_2", "display_name" => "home_section_2 ", 'category_id' => $categorypermission->id]);
            Permission::firstOrCreate(["name" => "edit_home_section_2", "display_name" => "edit_home_section_2", 'category_id' => $categorypermission->id]);
            Permission::firstOrCreate(["name" => "edit_home_section_3", "display_name" => "edit_home_section_3", 'category_id' => $categorypermission->id]);
            Permission::firstOrCreate(["name" => "edit_home_section_4", "display_name" => "edit_home_section_4 ", 'category_id' => $categorypermission->id]);

        $categoryaggregation = Categorypermission::where('name','aggregation')->firstOrFail();
            Permission::firstOrCreate(["name" => "pending_aggregation_in_dash", "display_name" => "pending aggregation in dashboard", 'category_id' => $categoryaggregation->id]);
            Permission::firstOrCreate(["name" => "all_pending_quantities", "display_name" => "all pending quantities", 'category_id' => $categoryaggregation->id]);
            Permission::firstOrCreate(["name" => "change_status_0f_quantity", "display_name" => "change status 0f quantity", 'category_id' => $categoryaggregation->id]);
            Permission::firstOrCreate(["name" => "pending_order_aggregations", "display_name" => "pending order aggregations", 'category_id' => $categoryaggregation->id]);
            Permission::firstOrCreate(["name" => "archived_order_aggregations", "display_name" => "archived order aggregations", 'category_id' => $categoryaggregation->id]);

        $category_aucation = Categorypermission::where('name','aucation')->firstOrFail();
            Permission::firstOrCreate(["name" => "pending_aucations_in_dash", "display_name" => "pending aucations in dashboard", 'category_id' => $category_aucation->id]);
            Permission::firstOrCreate(["name" => "all_suspend_prices", "display_name" => "all pending prices", 'category_id' => $category_aucation->id]);
            Permission::firstOrCreate(["name" => "change_status_0f_prices", "display_name" => "change status 0f prices", 'category_id' => $category_aucation->id]);
            Permission::firstOrCreate(["name" => "pending_order_aucation", "display_name" => "pending order aucations", 'category_id' => $category_aucation->id]);
            Permission::firstOrCreate(["name" => "archived_order_aucation", "display_name" => "archived order aucation", 'category_id' => $category_aucation->id]);

        $category_blog = Categorypermission::where('name','blog')->firstOrFail();
            Permission::firstOrCreate(["name" => "dash_all_suspend_comments", "display_name" => "all suspend comments", 'category_id' => $category_blog->id]);
            Permission::firstOrCreate(["name" => "dash_change_status_0f_comment", "display_name" => "change status 0f comment", 'category_id' => $category_blog->id]);

        $category_company = Categorypermission::where('name','company')->firstOrFail();
            Permission::firstOrCreate(["name" => "dash_all_suspend_companies", "display_name" => "all suspend companies", 'category_id' => $category_company->id]);

        $category_points = new Categorypermission();
            $category_points->name="points";
            $category_points->save();
            Permission::firstOrCreate(["name" => "dach_edit_price_point", "display_name" => "edit price of point ", 'category_id' => $category_points->id]);
            Permission::firstOrCreate(["name" => "dach_request_points", "display_name" => "request points", 'category_id' => $category_points->id]);
            Permission::firstOrCreate(["name" => "dach_archived_requests", "display_name" => "archived requests", 'category_id' => $category_points->id]);
            Permission::firstOrCreate(["name" => "dach_change_status_0f_request_points", "display_name" => "change status 0f request points", 'category_id' => $category_points->id]);
            Permission::firstOrCreate(["name" => "dach_request_transfer_points", "display_name" => "request transfer points", 'category_id' => $category_points->id]);
            Permission::firstOrCreate(["name" => "dach_archived_transfer_points", "display_name" => "archived transfer points", 'category_id' => $category_points->id]);
            Permission::firstOrCreate(["name" => "dach_change_status_0f_request_transfer_points", "display_name" => "change status 0f request transfer points", 'category_id' => $category_points->id]);

        $category_contact = new Categorypermission();
            $category_contact->name="contact";
            $category_contact->save();
            Permission::firstOrCreate(["name" => "index_contact", "display_name" => "index contact", 'category_id' => $category_contact->id]);
            Permission::firstOrCreate(["name" => "view_contact", "display_name" => "view contact", 'category_id' => $category_contact->id]);
            Permission::firstOrCreate(["name" => "delete_contact", "display_name" => "delete social", 'category_id' => $category_contact->id]);

        $category_subscripe = new Categorypermission();
            $category_subscripe->name="subscripe";
            $category_subscripe->save();
            Permission::firstOrCreate(["name" => "index_subscripe", "display_name" => "index subscripe", 'category_id' => $category_subscripe->id]);
            Permission::firstOrCreate(["name" => "view_subscripe", "display_name" => "view subscripe", 'category_id' => $category_subscripe->id]);
            Permission::firstOrCreate(["name" => "delete_subscripe", "display_name" => "delete subscripe", 'category_id' => $category_subscripe->id]);

        $category_product = Categorypermission::where('name','product')->firstOrFail();
            Permission::firstOrCreate(["name" => "dash_all_sold_products", "display_name" => "all sold products", 'category_id' => $category_product->id]);
            Permission::firstOrCreate(["name" => "dash_all_suspend_products", "display_name" => "all suspend products", 'category_id' => $category_product->id]);
            Permission::firstOrCreate(["name" => "dash_all_pending_review", "display_name" => "all pending review", 'category_id' => $category_product->id]);
            Permission::firstOrCreate(["name" => "dash_all_archived_review", "display_name" => "all archived review", 'category_id' => $category_product->id]);
            Permission::firstOrCreate(["name" => "dash_change_status_0f_review", "display_name" => "change status 0f review", 'category_id' => $category_product->id]);

        $category_help = new Categorypermission();
            $category_help->name="helps";
            $category_help->save();
            Permission::firstOrCreate(["name" => "dash_track_orders", "display_name" => "track orders", 'category_id' => $category_help->id]);
            Permission::firstOrCreate(["name" => "dash_faqs", "display_name" => "faqs", 'category_id' => $category_help->id]);
            Permission::firstOrCreate(["name" => "dash_shipping", "display_name" => "shipping", 'category_id' => $category_help->id]);
            Permission::firstOrCreate(["name" => "dash_returns", "display_name" => "returns", 'category_id' => $category_help->id]);
            Permission::firstOrCreate(["name" => "dash_delete_helps", "display_name" => "delete helps", 'category_id' => $category_help->id]);
            Permission::firstOrCreate(["name" => "dash_create_helps", "display_name" => "create helps", 'category_id' => $category_help->id]);
            Permission::firstOrCreate(["name" => "dash_edit_helps", "display_name" => "edit helps", 'category_id' => $category_help->id]);
    }

}
