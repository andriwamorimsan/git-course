<?php


namespace App\Http\Controllers;
use App\Http\Requests\StoreUpdatePost;
use Illuminate\Http\Request;
use App\Models\Post;
class PostController extends Controller
{
    public function index(){

        $posts = Post::latest()->paginate(5);

        return view('admin.posts.index', compact('posts'));
    }

    public function create(){
        return view('admin.posts.create');
    }

    public function store(StoreUpdatePost $request){

        Post::create($request->all());
        return redirect()
            ->route('posts.index')
            ->with('message','Ola!');
    }

    public function show($id){
        $post = Post::find($id);
        if(!$post){
            return redirect()->route('posts.index');
        }
        return view('admin.posts.show', compact('post'));
    }

    public function destroy($id)
    {
        if(!$post = Post::find($id))
            return redirect()->route('post.index');
        $post->delete();
            return redirect()
                ->route('posts.index')
                ->with('message', 'Post Deletado com sucesso');

    }

    public function edit($id){
        if(!$post = Post::find($id)){
            return redirect()->back();
        }
        return view('admin.posts.edit', compact('post'));
    }

    public function update(StoreUpdatePost $request, $id){
        if(!$post = Post::find($id)){
            return redirect()->back();

        }
        $post->update($request->all());
        return redirect()
            ->route('posts.index')
            ->with('message','Post Autalizado com Sucesso');
    }

    public function search(Request $request)
    {

        $filters = $request->except('_token');

        $posts = Post::where('title', 'LIKE', "%{$request->search}%")
                            ->orWhere('content', 'LIKE', "%{$request->search}%")
                            ->paginate(3);
                        return view('admin.posts.index', compact('posts', 'filters'));
    }
    public function index2(){

      /*  $posts = Post::latest()->paginate(5);*/

        return view('admin.posts.index2');
    }
}
