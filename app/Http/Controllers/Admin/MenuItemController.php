<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContentRequest;
use App\Models\MenuItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuItemController extends Controller
{
    public function index(Request $request): View
    {
        $location = array_key_exists($request->query('location'), MenuItem::LOCATIONS) ? $request->query('location') : 'header';

        // All items of the menu (active and hidden), as a tree.
        $items = MenuItem::where('location', $location)->orderBy('sort_order')->orderBy('id')->get();
        $tree = $items->whereNull('parent_id')->map(fn ($item) => $this->withChildren($item, $items));

        return view('admin.menus.index', compact('location', 'tree'));
    }

    public function create(Request $request): View
    {
        $location = array_key_exists($request->query('location'), MenuItem::LOCATIONS) ? $request->query('location') : 'header';

        return view('admin.menus.form', [
            'item' => new MenuItem(['location' => $location, 'is_active' => true, 'parent_id' => $request->query('parent')]),
            'parents' => $this->parentOptions($location),
        ]);
    }

    public function store(ContentRequest $request): RedirectResponse
    {
        $item = MenuItem::create($request->validated());

        return redirect()->route('admin.menus.index', ['location' => $item->location])->with('success', "Menu item \"{$item->label}\" added.");
    }

    public function edit(MenuItem $menu): View
    {
        return view('admin.menus.form', ['item' => $menu, 'parents' => $this->parentOptions($menu->location, $menu)]);
    }

    public function update(ContentRequest $request, MenuItem $menu): RedirectResponse
    {
        $menu->update($request->validated());

        return redirect()->route('admin.menus.index', ['location' => $menu->location])->with('success', "Menu item \"{$menu->label}\" saved.");
    }

    public function destroy(MenuItem $menu): RedirectResponse
    {
        $location = $menu->location;
        $menu->delete(); // sub-items are removed with it (foreign key cascade)

        return redirect()->route('admin.menus.index', ['location' => $location])->with('success', 'Menu item deleted.');
    }

    private function withChildren(MenuItem $item, $all): MenuItem
    {
        $item->setRelation('allChildren', $all->where('parent_id', $item->id)->map(fn ($c) => $this->withChildren($c, $all))->values());

        return $item;
    }

    /** Items that can be a parent: top level and second level (max. 3 levels deep), excluding the item itself and its descendants. */
    private function parentOptions(string $location, ?MenuItem $current = null): array
    {
        $items = MenuItem::where('location', $location)->orderBy('sort_order')->orderBy('id')->get();
        $excluded = $current ? $this->descendantIds($current, $items)->push($current->id) : collect();
        $options = [];
        foreach ($items->whereNull('parent_id') as $top) {
            if ($excluded->contains($top->id)) {
                continue;
            }
            $options[$top->id] = $top->label;
            foreach ($items->where('parent_id', $top->id) as $child) {
                if (! $excluded->contains($child->id)) {
                    $options[$child->id] = '— '.$child->label;
                }
            }
        }

        return $options;
    }

    private function descendantIds(MenuItem $item, $all)
    {
        return $all->where('parent_id', $item->id)->flatMap(fn ($c) => $this->descendantIds($c, $all)->push($c->id))->values();
    }
}
