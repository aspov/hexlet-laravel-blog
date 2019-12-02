<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Http\Requests\ArticleValidate;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');        
        $articles = $q ? Article::where('name', 'like', "%{$q}%")->paginate() : Article::paginate();
        return view('article.index', compact('articles', 'q'));
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);
        return view('article.show', compact('article'));
    }

	// Вывод формы
    public function create()
    {
        // Передаем в шаблон вновь созданный объект. Он нужен для вывода формы через Form::model
        $article = new Article();
        return view('article.create', compact('article'));
    }

    public function store(Request $request)
    {
        // Проверка введенных данных
        // Если будут ошибки, то возникнет исключение
        $this->validate($request, [
            'name' => 'required|unique:articles',
            'body' => 'required|min:5',
        ]);

        $article = new Article();
        // Заполнение статьи данными из формы
        $article->fill($request->all());
        // При ошибках сохранения возникнет исключение
        $article->save();
	
	#$request->session()->flash('status', 'Article was created!');
	
        // Редирект на указанный маршрут с добавлением флеш сообщения
        return redirect()
            ->route('articles.index')->with('status', 'Article was created!');
    }

	public function edit($id)
	{
	    $article = Article::findOrFail($id);
	    return view('article.edit', compact('article'));
	}

	public function update(ArticleValidate $request, $id)
	{
	    $article = Article::findOrFail($id);
/*
	    $this->validate($request, [
		// У обновления немного измененная валидация. В проверку уникальности добавляется название поля и id текущего объекта
		// Если этого не сделать, Laravel будет ругаться на то что имя уже существует
		'name' => 'required|unique:articles,name,' . $article->id,
		'body' => 'required|min:5',
	    ]);
*/
	    $request->validated();
		
	    $article->fill($request->all());
	    $article->save();
	    return redirect()
		->route('articles.index')->with('status', 'Article was updated!');
	}

	// Не забывайте про авторизацию (здесь не рассматривается)
// Удаление должно быть доступно только тем, кто может его выполнять
	public function destroy($id)
	{
	    // DELETE идемпотентный метод, поэтому результат операции всегда один и тот же
	    $article = Article::find($id);
	    if ($article) {
	      $article->delete();
	    }
	    return redirect()->route('articles.index')->with('status', 'Article was deleted!');
	}
}
