@card(['title' => "Most Commented" , 'elements' => collect($mostCommented) ,'elementFeature' => 'title',
'needLink' => true])
    @slot('subtitle')
        What people are currently talking about?
    @endslot
    @slot( 'noElementDetail' )
        Currently , There is no commented post.
    @endslot
@endcard


@card(['marginTop' => 'mt-4' , 'title' => "Most Active Users" ,
'elements' => collect($mostActiveUsers) ,'elementFeature' => 'name'])
    @slot('subtitle')
        Which users have more posts?
    @endslot
    @slot( 'noElementDetail' )
        Currently , There is no active user.
    @endslot
@endcard


@card(['marginTop' => 'mt-4' , 'title' => "Most Active Users In The Last Month" ,
'elements' => collect($mostActiveUsersInLastMonth) ,'elementFeature' => 'name'])
    @slot('subtitle')
        Which users have more posts in last month?
    @endslot
    @slot( 'noElementDetail' )
        Currently , There is no active user.
    @endslot
@endcard
