@component('mail::message')
# Comment Was Posted On Your BlogPost

Hi {{ $comment->commentable->user->name }},
{{-- in fact commentable here is blog post --}}
Some one has commented on your blog post.

@component('mail::button', ['url' => route('posts.show' , ['post' => $comment->commentable->id])])
View The BlogPost {{ $comment->commentable->title }}
@endcomponent

@component('mail::button', ['url' => route('users.show' , ['user' => $comment->user->id])])
Visit {{ $comment->user->name }} Profile
@endcomponent


@component('mail::panel')
    {{ $comment->contents }}
@endcomponent
Thanks,<br>
{{ config('app.name') }}
@endcomponent
