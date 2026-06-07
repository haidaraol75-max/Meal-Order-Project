<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMenuItemRequest;
use App\Http\Requests\UpdateMenuItemRequest; 
use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;


class MenuItemController extends Controller
{
   
    public function index()
    {
        $menuItems = MenuItem::with('category')->get(); // لتجنب مشكلة الاستعلام الزائد 
        return response()->json($menuItems);
    }
    
    public function store(StoreMenuItemRequest $request)
    {
        
        $validatedData = $request->validated();
       
        
        if($request->hasFile('image'))
        {
          $path = $request->file('image')->store('menu_images', 'public'); 
          $validatedData['image'] = $path; 
        }

        $menuItem = MenuItem::create($validatedData);
        return response()->json(['message'=>'Menu item created successfully',
        'data'=> $menuItem],201);
    } 


    public function update(UpdateMenuItemRequest $request, MenuItem $menuItem)
    {
       $validatedData = $request->validated();

       if ($request->hasFile('image'))
       {

        // حذف الصورة القديمة إذا كانت موجودة
        if ($menuItem->image) 
        {
            Storage::disk('public')->delete($menuItem->image);
        }

        // رفع الصورة الجديدة
        $path = $request->file('image')->store('menu_images', 'public');
        $validatedData['image'] = $path;
        }

        $menuItem->update($validatedData);// _________2

         return response()->json([
        'message' => 'Menu item updated successfully',
        'data' => $menuItem->fresh() // ______3
         ]);
         /* Laravel سيقوم تلقائياً بـ: 
     MenuItem::findOrFail($id) خلف الكواليس
     */
    }

    public function updateStatus(MenuItem $menuItem)
    {
        if ($menuItem->availability == 1) 
        {
           $menuItem->update(['availability' => 0]); // قم بإيقافها
           $messageText = 'Menu item disabled successfully';
        } 
   
       else 
        {
          $menuItem->update(['availability' => 1]); // قم بتفعيلها
          $messageText = 'Menu item enabled successfully';
        }

       return response()->json([
          'message' => $messageText,
         'data' => $menuItem
         ]);
    }
    
    public function destroy(MenuItem $menuItem)
    {
        // 1. حذف الصورة من الخادم أولاً حتى لا تأخذ مساحة
        if ($menuItem->image)
        {
          Storage::disk('public')->delete($menuItem->image);
        }

        // 2. حذف الوجبة (حذف ناعم)
         $menuItem->delete(); 

         return response()->json([
        'message' => 'Menu item deleted successfully from the menu'
         ]);
    }

    public function show(MenuItem $menuItem)
    {
       return response()->json([
        'data' => $menuItem
       ]);
    }


}

    


