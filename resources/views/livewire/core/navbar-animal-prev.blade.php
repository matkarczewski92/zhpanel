<div style="float: right;" class="me-3">
      <div class="conteinter text-end">
        @if ($prev)
        <a href="{{ route('animal.profile', $prev)}}"><i class="bi bi-arrow-left-circle-fill fs-3 me-2"></i></a>
        @endif
        @if ($next)
          <a href="{{ route('animal.profile', $next)}}"><i class="bi bi-arrow-right-circle-fill fs-3"></i></a>
        @endif
      </div>
  </div>