<?php

namespace App\Tools;

use App\Models\Tool;
use Illuminate\Http\Request;
use App\Contracts\ToolInterface;

class RemoveBackground implements ToolInterface
{
    public function render(Request $request, Tool $tool)
    {
        return view('tools.remove-background', compact('tool'));
    }

    public function handle(Request $request, Tool $tool)
    {
        $url_array = [];
        $keyword = $request->input('keyword', null);
        $url = $request->input('url', null);
        if ($request->file('file')) {
            $validated = $request->validate([
                'file' => "required|max:" . $tool->fs_tool * 1024
            ]);
        }

        $results = [
            'keyword' => $keyword,
            'url' => $url,
        ];

        return view('tools.remove-background', compact('results', 'tool'));
    }
}
