@foreach ($blogs as $blog)
<div class="post-item" data-id="{{ $blog->id }}">
    <div class="post-thumb">
        <a href="blog-details.html">
            @if ($blog->blogDetails && $blog->blogDetails->cover_image)
                <img src="{{ asset('storage/' . $blog->blogDetails->cover_image) }}" alt="blog">
            @endif
        </a>
    </div>
    <div class="post-content">
        <div class="post-header">
            <h4 class="title">
                <a href="blog-details.html">
                    {{ $blog->title }}
                </a>
            </h4>
            <div class="meta-post">
                <a href="#0" class="mr-4"><i class="flaticon-conversation"></i>20
                    Comments</a>
                <a href="#0"><i class="flaticon-view"></i>466 View</a>
            </div>
            <p class="description">
                {{ $blog->blogDetails->short_description }}
            </p>
        </div>
        <div class="entry-content">
            <div class="left">
                <span class="date">{{ $blog->created_at->format('M d, Y') }} BY </span>
                <div class="authors">
                    <div class="thumb">
                        <a href="#0"><img src="{{ asset('frontend/images/blog/author.jpg') }}" alt="#0"></a>
                    </div>
                    <h6 class="title"><a href="#0">Alvin Mcdaniel</a></h6>
                </div>
            </div>
            <a href="#0" class="buttons">Read More <i class="flaticon-right"></i></a>
        </div>
    </div>
</div>
@endforeach
