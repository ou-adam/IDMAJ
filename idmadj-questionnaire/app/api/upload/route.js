import { put } from '@vercel/blob';

export async function POST(request) {
  try {
    const { searchParams } = new URL(request.url);
    const filename = searchParams.get('filename') || 'upload.bin';

    if (!process.env.BLOB_READ_WRITE_TOKEN) {
      // If Vercel Blob is not configured yet, fallback to mock upload for local testing
      console.warn("BLOB_READ_WRITE_TOKEN is missing. Returning local mock URL.");
      const mockUrl = `/mock-uploads/${Date.now()}-${filename}`;
      return Response.json({ url: mockUrl, message: "Mock upload success (local test)" });
    }

    // Read the body as an arrayBuffer
    const arrayBuffer = await request.arrayBuffer();
    const buffer = Buffer.from(arrayBuffer);

    // Upload to Vercel Blob
    const blob = await put(filename, buffer, {
      access: 'public',
    });

    return Response.json({ url: blob.url });
  } catch (error) {
    console.error('Upload error:', error);
    return Response.json({ error: error.message }, { status: 500 });
  }
}
