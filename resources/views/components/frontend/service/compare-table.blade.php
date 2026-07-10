<section class="bg-surface border-y border-line">
  <div class="mx-auto max-w-7xl px-6 py-16 lg:py-20">
    <div class="max-w-2xl mb-10">
      <span class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase"><span class="w-7 h-px bg-accent"></span> เปรียบเทียบบริการ</span>
      <h2 class="mt-3 text-3xl font-bold tracking-tight text-navy-900">ราคาและระยะเวลาโดยสังเขป</h2>
    </div>
    <div class="overflow-x-auto rounded-2xl ring-1 ring-line">
      <table class="w-full min-w-[640px] bg-white text-[15px]">
        <thead>
          <tr class="border-b border-line bg-surface text-navy-900 font-semibold">
            @foreach ($columns as $column)
              <th @class([
                'px-6 py-4',
                'text-left' => ($column['align'] ?? 'center') === 'left',
                'text-center' => ($column['align'] ?? 'center') !== 'left',
              ])>{{ $column['label'] }}</th>
            @endforeach
          </tr>
        </thead>
        <tbody>
          @forelse ($services as $service)
            <tr @class([
              'border-b border-line hover:bg-accent/5 transition',
              'bg-surface/50' => $loop->even,
            ])>
              <td class="px-6 py-4 font-semibold text-navy-900">{{ $service->title }}</td>
              <td class="px-6 py-4 text-center font-mono font-bold text-navy-900 tabular-nums">
                @if ($service->lowestPrice?->price !== null)
                  {{ number_format((float) $service->lowestPrice->price, 0) }}
                @else
                  <span class="text-muted font-sans font-medium">สอบถาม</span>
                @endif
              </td>
              <td class="px-6 py-4 text-center text-muted text-[14px]">
                @if ($service->lowestPrice?->unit)
                  บาท/{{ $service->lowestPrice->unit }}
                @else
                  —
                @endif
              </td>
              <td class="px-6 py-4 text-center text-ink2">{{ $service->dur ?: '—' }}</td>
              <td class="px-6 py-4 text-center text-[14px]">
                @if ($warranty = $service->scopes->firstWhere('group', 'warranty'))
                  <span class="text-green-700 font-medium"><i class="bi bi-shield-check-fill text-green-600 mr-1"></i>{{ $warranty->name }}</span>
                @else
                  <span class="text-muted">—</span>
                @endif
              </td>
              <td class="px-6 py-4 text-center">
                @if ($service->scopes->contains('group', 'cert'))
                  <i class="bi bi-check-circle-fill text-accent text-lg"></i>
                @else
                  <span class="text-muted">—</span>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="{{ count($columns) }}" class="px-6 py-8 text-center text-muted">ยังไม่มีข้อมูลราคา</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <p class="mt-4 text-[13px] text-muted">* ราคาข้างต้นเป็นราคาเริ่มต้น ราคาจริงขึ้นอยู่กับขนาดงาน วัสดุ และสภาพหน้างาน · รับสำรวจและเสนอราคาฟรี</p>
  </div>
</section>
