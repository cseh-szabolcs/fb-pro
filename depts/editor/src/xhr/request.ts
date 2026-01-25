export async function request(
  path: string,
  method: 'GET' | 'POST' = 'GET',
) {

  const response = await fetch(`${window.APP_URL}${path}`, {
    method,
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest',
      'Authorization': AUTH_TOKEN
        ? `Bearer ${AUTH_TOKEN}`
        : '0',
    },
  });

  if (response.headers.has(HEADER_NEW_TOKEN)) {
    AUTH_TOKEN = response.headers.get(HEADER_NEW_TOKEN) as string;
  }

  return response;
}

let AUTH_TOKEN = window.AUTH_TOKEN;
const HEADER_NEW_TOKEN = 'X-Authorization-Token';
