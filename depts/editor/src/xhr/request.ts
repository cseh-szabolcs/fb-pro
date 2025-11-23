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
      'Authorization': APP_AUTHORIZATION ? `Bearer ${APP_AUTHORIZATION}` : '0',
    },
  });

  if (response.headers.has(HEADER_NEW_TOKEN)) {
    APP_AUTHORIZATION = response.headers.get(HEADER_NEW_TOKEN) as string;
  }

  return response;
}

let APP_AUTHORIZATION = window.APP_AUTHORIZATION;
const HEADER_NEW_TOKEN = 'X-Authorization-Token';
