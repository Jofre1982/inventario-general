@php($ok = in_array($status, ['VALID', 'ACTIVE']))
<span class="badge badge-{{ $ok ? 'success' : 'danger' }}">{{ status_label($status) }}</span>
