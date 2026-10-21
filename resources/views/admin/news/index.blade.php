@extends('admin.layouts.app')

@section('title', 'Kelola Berita CMS')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h3 class="fw-bold text-dark m-0">Kelola Berita & Content CMS</h3>
        <p class="text-muted small m-0 mt-1">Kelola artikel berita, posisi headline beranda, dan penilaian SEO Yoast-Style.</p>
    </div>
    <a href="{{ route('admin.news.create') }}" class="btn btn-mbe d-inline-flex align-items-center gap-2">
        <i class="fa-solid fa-plus"></i> Tambah Berita Baru
    </a>
</div>

<div class="card card-custom p-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr class="text-secondary fs-7">
                    <th style="width: 80px;">Gambar</th>
                    <th>Judul Berita</th>
                    <th style="width: 130px;">Tanggal</th>
                    <th class="text-center" style="width: 150px;">Headline Hero</th>
                    <th class="text-center" style="width: 170px;">SEO Score</th>
                    <th class="text-end" style="width: 120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($news as $item)
                <tr>
                    <td>
                        @if($item->image)
                        <img src="{{ asset($item->image) }}" alt="{{ $item->title }}" class="rounded-3 border object-fit-cover" style="width: 60px; height: 45px;">
                        @else
                        <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted border small" style="width: 60px; height: 45px;">No Img</div>
                        @endif
                    </td>
                    <td>
                        <div class="fw-bold text-dark">{{ $item->title }}</div>
                        <div class="text-muted small">Slug: /berita/{{ $item->slug }}</div>
                    </td>
                    <td class="text-secondary small">
                        <i class="fa-regular fa-calendar-days text-info"></i> {{ \Carbon\Carbon::parse($item->published_at)->format('d M Y') }}
                    </td>
                    <td class="text-center">
                        <form action="{{ route('admin.news.toggle-headline', $item->id) }}" method="POST" class="m-0">
                            @csrf
                            @if($item->is_headline)
                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 py-1 fw-bold fs-7" title="Klik untuk menonaktifkan headline">
                                <i class="fa-solid fa-star"></i> HEADLINE
                            </button>
                            @else
                            <button type="submit" class="btn btn-sm btn-light border rounded-pill px-3 py-1 text-secondary fs-7" title="Klik untuk menjadikan headline utama beranda">
                                <i class="fa-regular fa-star"></i> Standar
                            </button>
                            @endif
                        </form>
                    </td>
                    <td class="text-center">
                        @php $status = $item->seo_status; @endphp
                        @if($item->seo_score >= 80)
                            <span class="badge bg-success-subtle text-success-emphasis rounded-pill px-3 py-2 fw-bold">
                                <i class="fa-solid fa-chart-line"></i> {{ $item->seo_score }}% (Bagus)
                            </span>
                        @elseif($item->seo_score >= 50)
                            <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill px-3 py-2 fw-bold">
                                <i class="fa-solid fa-chart-line"></i> {{ $item->seo_score }}% (Perlu Perbaikan)
                            </span>
                        @else
                            <span class="badge bg-danger-subtle text-danger-emphasis rounded-pill px-3 py-2 fw-bold">
                                <i class="fa-solid fa-chart-line"></i> {{ $item->seo_score }}% (Kurang)
                            </span>
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.news.edit', $item->id) }}" class="btn btn-sm btn-outline-info rounded-circle" style="width: 32px; height: 32px;" title="Edit Berita">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" style="width: 32px; height: 32px;" title="Hapus Berita">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        <i class="fa-solid fa-newspaper fs-1 mb-2 d-block text-secondary"></i>
                        Belum ada data berita. Klik tombol <strong>Tambah Berita Baru</strong> di atas untuk membuat artikel pertama.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($news->hasPages())
    <div class="mt-3 px-2">
        {{ $news->links() }}
    </div>
    @endif
</div>

@endsection
