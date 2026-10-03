import apiClient from '@/api/client';
import { endpoints } from '@/api/endpoints';
import type { ApiResponse } from '@/types/api';
import type { Project } from '@/types/project';

export async function fetchProjects(params?: {
  featured?: boolean;
}): Promise<Project[]> {
  const { data } = await apiClient.get<ApiResponse<Project[]>>(endpoints.projects, {
    params,
  });
  return data.data;
}

export async function fetchProject(slug: string): Promise<Project> {
  const { data } = await apiClient.get<ApiResponse<Project>>(endpoints.project(slug));
  return data.data;
}
