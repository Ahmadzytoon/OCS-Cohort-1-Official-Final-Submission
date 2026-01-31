<!DOCTYPE html>
<html>
<body>
  <h2>Hello {{ $request->student->name }}</h2>

  <p>
    Your request with teacher
    <strong>{{ $request->teacherProfile->display_name }}</strong>
    has been updated.
  </p>

  <p>
    <strong>New status:</strong> {{ ucfirst($request->status) }}
  </p>

  {{-- يظهر فقط إذا كانت الحالة Completed --}}
  @if($request->status === 'completed')
    <p style="margin-top:12px;">
      You can now rate and review the teacher from your Mentory account.
    </p>
  @endif

  <p>
    Thank you for using <strong>Mentory</strong>.
  </p>
</body>
</html>
