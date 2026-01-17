using System.Collections.Generic;
using UnityEngine;

public static class NormalBaker
{
    public static void BakeNormal(GameObject obj, float tolerance = 1e-6f)
    {
        var meshFilters = obj.GetComponentsInChildren<MeshFilter>();

        foreach (var meshFilter in meshFilters)
        {
            var mesh = meshFilter.sharedMesh;
            var normals = mesh.normals;
            var vertices = mesh.vertices;
            var vertexCount = mesh.vertexCount;

            // 頂点位置ごとに法線をまとめる
            var dict = new Dictionary<Vector3, List<Vector3>>(vertexCount);

            for (int i = 0; i < vertexCount; i++)
            {
                var v = Quantize(vertices[i], tolerance); // 誤差を吸収
                if (!dict.ContainsKey(v))
                    dict[v] = new List<Vector3>();
                dict[v].Add(normals[i]);
            }

            // 平均化した法線を頂点カラーに格納
            var softEdges = new Color[vertexCount];
            for (int i = 0; i < vertexCount; i++)
            {
                var v = Quantize(vertices[i], tolerance);
                var avg = Average(dict[v]);
                softEdges[i] = new Color(avg.x, avg.y, avg.z, 0);
            }

            mesh.colors = softEdges;
        }
    }

    // 頂点座標を丸めて近似一致を実現
    private static Vector3 Quantize(Vector3 v, float tolerance)
    {
        return new Vector3(
            Mathf.Round(v.x / tolerance) * tolerance,
            Mathf.Round(v.y / tolerance) * tolerance,
            Mathf.Round(v.z / tolerance) * tolerance
        );
    }

    // 法線の平均を計算
    private static Vector3 Average(List<Vector3> list)
    {
        var sum = Vector3.zero;
        foreach (var n in list) sum += n;
        return sum.normalized;
    }
}