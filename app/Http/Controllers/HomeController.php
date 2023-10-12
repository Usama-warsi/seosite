<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\Category;
use Illuminate\Http\Request;
use Butschster\Head\Facades\Meta;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Classes\UpdatesManager;
use Illuminate\Support\Facades\Session;
use DB;
class HomeController extends ToolController
{
    public function home()
    {
        $tool = Tool::with('translations')->withCount('usageToday')->with('category')->index()->active()->first();
          Session::forget('tool');

        if ($tool && class_exists($tool->class_name) && method_exists($tool->class_name, 'index') && method_exists($tool->class_name, 'handle')) {
            $tool->load('category');
            $instance = new $tool->class_name();
            $tool->createVisitLog(auth()->user());
            $relevant_tools = Tool::with('translations')->withCount('usageToday')->with('category')->active()->take('16')->orderBy('display')->get();
            Meta::setMeta($tool);

            return  $instance->index($tool, $relevant_tools);
        }
        Meta::setMeta();

        return $this->tools();
    }
    public function dashboard()
    {
                    //   Session::forget('tool');
   if(Auth()->user()){ $visitorId = Auth()->user()->id;

            $subquery = DB::table('history')
            ->select(DB::raw('COUNT(`visitable_id`)'))
            ->whereRaw('history.visitable_id = tool_translations.tool_id');
        
        $query = DB::table('history')
            ->select(
                DB::raw('DISTINCT(`visitable_id`) AS TOOL_IDS'),
                DB::raw('(' . $subquery->toSql() . ') AS used_count'),
                'tool_translations.tool_id',
                'tool_translations.name',
                'tools.slug',
                'tools.class_name',
                'tools.icon_type',
                'tools.icon_class',
                'tools.status'
            )
            ->join('tool_translations', 'history.visitable_id', '=', 'tool_translations.tool_id')
            ->join('tools', 'tools.id', '=', 'tool_translations.tool_id')
            ->where('visitor_id', $visitorId)
            ->limit(5);
            
            $results = $query->get();
            Session::put('recenttool', $results);

            $query = DB::table('reports')
            ->select(DB::raw('DISTINCT `Site_name`'), 'user_id','site_screen', 'report_link', 'created_at')
            ->where('user_id', $visitorId)->orderBy('created_at', 'desc');
        
        $results = $query->get();
Session::put('reports', $results);
        $tool = Tool::with('translations')->withCount('usageToday')->with('category')->index()->active()->first();

         $tools = Category::query()
            ->active()
            ->tool()
            ->with('translations')
            ->with(['tools' => function ($query) {
                $query->active()->with('translations')->orderBy('display');
            }])
            ->get();
            Session::put('tool', $tools);
            
        if ($tool && class_exists($tool->class_name) && method_exists($tool->class_name, 'index') && method_exists($tool->class_name, 'handle')) {
            $tool->load('category');
            $instance = new $tool->class_name();
            $tool->createVisitLog(auth()->user());
            $relevant_tools = Tool::with('translations')->withCount('usageToday')->with('category')->active()->take('16')->get();
            Meta::setMeta($tool);

            return  $instance->index($tool, $relevant_tools);
        }


        return $this->tools();}
   else{
       return redirect('login');
   }
    }
    public function tools()
    {
        $favorties = Auth::check() ? Auth::user()->favorite_tools : null;
        $tools = Category::query()
            ->active()
            ->tool()
            ->with('translations')
            ->with(['tools' => function ($query) {
                $query->active()->with('translations')->orderBy('display');
            }])
            ->orderBy('order')
            ->get();

        $ads = ['above-tool', 'above-form', 'below-form', 'above-result', 'below-result'];
        Meta::setMeta();

        return view('index', compact('tools', 'ads', 'favorties'));
    }

    public function homeTool(Request $request)
    {
        $tool = Tool::with('translations')->where('is_home', true)->active()->firstOrFail();
        Meta::setMeta($tool);

        return $this->handle($request, $tool->slug);
    }
}
