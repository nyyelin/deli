<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon;
use App\Way;
use Illuminate\Support\Facades\DB;
use Auth;

class WayDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'way:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will clean Delay way of deliverman';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // yangon ->
        $pending_ways = Way::where('status_code','!=',001)
                        ->where('status_code','!=',002)
                        ->where('deleted_at',null)
                        ->with(array('delivery_man'=>function($q){
                                        $q->where('city_id','!=','1')->get();
                                    }))
                        ->with(array('item'=>function($query){
                            $query->where('township_id',"!=",null)->get();
                        }))
                        ->orderBy('id','desc')
                        ->whereDate('created_at',Carbon\Carbon::today())->get();
   

        foreach ($pending_ways as $value) {

          if($value->delivery_man != null && $value->item != null){

                // var_dump($value->id);
                $way = Way::find($value->id);
                $way->status_code = "002";
                $way->status_id = 2;
                $way->remark = "မပို့ဖြစ်ပါ";
                $way->save();
                $way->delete();

                $day = $way->created_at;
                $date = date('Y-m-d',strtotime($day."+1 day"));
                $way->item->expired_date = $date;
                $way->item->error_remark = "မပို့ဖြစ်ပါ";
                $way->item->save();
            }
        }

        echo "operation success";
    }
}
