<?php

namespace Canvas\Http\Controllers;

use Canvas\Topic;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TopicController extends Controller
{
    /**
     * Get all of the topics.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data = [
            'topics' => Topic::orderBy('created_at', 'desc')->get(),
        ];

        return view('canvas::topics.index', compact('data'));
    }

    /**
     * Create a new topic.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data = [
            'id' => Str::uuid(),
        ];

        return view('canvas::topics.create', compact('data'));
    }

    /**
     * Edit a given topic.
     *
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function edit(string $id)
    {
        $topic = Topic::where('id', '=', $id)->first();
        if ($topic == null) {
            abort(404);
        }

        $data = [
            'topic' => $topic,
        ];

        return view('canvas::topics.edit', compact('data'));
    }

    /**
     * Save a new topic.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $data = [
            'id' => request('id'),
            'name' => request('name'),
            'slug' => request('slug'),
        ];

        $messages = [
            'unique' => __('canvas::validation.unique'),
        ];

        validator($data, [
            'name' => 'required',
            'slug' => 'required|' . Rule::unique('canvas_topics', 'slug')->ignore(request('id')) . '|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/i',
        ], $messages)->validate();

        $topic = new Topic(['id' => request('id')]);
        $topic->fill($data);
        $topic->save();

        return redirect(route('canvas.topic.edit', $topic->id))->with('notify', __('canvas::nav.notify.success'));
    }

    /**
     * Save a given topic.
     *
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(string $id)
    {

        $topic = Topic::where('id', '=', $id)->first();
        if ($topic == null) {
            abort(404);
        }

        $data = [
            'id' => request('id'),
            'name' => request('name'),
            'slug' => request('slug'),
        ];

        $messages = [
            'unique' => __('canvas::validation.unique'),
        ];

        validator($data, [
            'name' => 'required',
            'slug' => 'required|' . Rule::unique('canvas_topics', 'slug')->ignore(request('id')) . '|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/i',
        ], $messages)->validate();

        $topic->name = request('name');
        $topic->slug = request('slug');
        $topic->update();

        return redirect(route('canvas.topic.edit', $topic->id))->with('notify', __('canvas::nav.notify.success'));
    }

    /**
     * Delete a given topic.
     *
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        $topic = Topic::findOrFail($id);
        $topic->delete();

        return redirect(route('canvas.topic.index'));
    }
}
